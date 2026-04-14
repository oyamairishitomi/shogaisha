@extends('layouts.app')
@section('content')

<main class="max-w-3xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-8">管理画面</h1>
    <a href="{{ url('/admin/users') }}" class="text-blue-800 hover:underline text-sm">ユーザー一覧</a>

    <h2 class="font-bold mt-8 mb-4">記事一覧</h2>
    @foreach($articles as $article)
    <div class="flex items-center justify-between border-b py-2">
        <a href="{{ route('articles.show', $article) }}" class="text-sm hover:underline">{{ $article->title }}</a>
        <form action="{{ url('/admin/articles/' . $article->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs text-gray-400 hover:text-red-600">消す</button>
        </form>
    </div>
    @endforeach

    <h2 class="font-bold mt-8 mb-4">追記一覧</h2>
@foreach($entries as $entry)
<div class="border-b py-2">
    <div class="flex items-center justify-between">
        <div class="text-sm">{{ $entry->article?->title ?? '(記事削除済み)' }} への追記</div>
        <form action="{{ route('admin.entries.destroy', $entry) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-xs text-gray-400 hover:text-red-600">消す</button>
        </form>
    </div>
    <div class="text-xs text-gray-600 mt-1">{!! strip_tags($entry->body) !!}</div>
</div>
@endforeach


</main>

@endsection
