@extends('layouts.app')
@section('content')

<main id="main" class="max-w-3xl mx-auto px-4 py-8">
    <div id="article-list">
        @include('articles._item')
    </div>

    {{-- スクロールの監視対象。次のページURLをdata属性で持たせる --}}
    <div id="load-more-trigger" data-next="{{ $articles->nextPageUrl() }}"></div>
</main>

<script>
(function () {
    const trigger = document.getElementById('load-more-trigger');
    let nextUrl = trigger.dataset.next; // 最初の「次ページURL」
    let loading = false;

    // 次ページがなければ何もしない
    if (!nextUrl) return;

    // triggerが画面内に入ったときに発火するオブザーバー
    const observer = new IntersectionObserver(async (entries) => {
        if (!entries[0].isIntersecting || loading || !nextUrl) return;
        loading = true;

        // LaravelにAjaxリクエストを投げる（このヘッダーがないと$request->ajax()がfalseになる）
        const res = await fetch(nextUrl, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const data = await res.json(); // { html: '...', next_page: '...' }

        // 取得したHTMLを一覧の末尾に追加
        document.getElementById('article-list').insertAdjacentHTML('beforeend', data.html);

        nextUrl = data.next_page ?? null; // 次の次ページURL（なければnull）
        loading = false;

        if (!nextUrl) observer.disconnect(); // もうページがなければ監視終了
    });

    observer.observe(trigger); // triggerの監視を開始
})();
</script>

@endsection
