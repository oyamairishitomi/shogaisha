@php
use App\Services\RubyService;
$ruby = new RubyService();
@endphp
@extends('layouts.app')
@section('content')

<main id="main" class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-bold mb-8">{!! $ruby->addRuby('プライバシーポリシー・削除ポリシー') !!}</h1>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('収集する情報') !!}</h2>
        <ul class="text-sm leading-relaxed list-disc pl-5">
            <li>{!! $ruby->addRuby('メールアドレス（認証目的）') !!}</li>
            <li>{!! $ruby->addRuby('IPアドレス（投稿時に収集）') !!}</li>
            <li>{!! $ruby->addRuby('投稿内容') !!}</li>
        </ul>
    </section>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('収集目的') !!}</h2>
        <ul class="text-sm leading-relaxed list-disc pl-5">
            <li>{!! $ruby->addRuby('サービスの提供・運営') !!}</li>
            <li>{!! $ruby->addRuby('荒らし行為・不正利用の防止') !!}</li>
            <li>{!! $ruby->addRuby('法的機関からの正式な開示請求への対応') !!}</li>
        </ul>
    </section>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('IPアドレスの収集について') !!}</h2>
        <p class="text-sm leading-relaxed">{!! $ruby->addRuby('本サービスは投稿時にIPアドレスを収集します。収集目的は荒らし行為・不正利用の防止および法的機関からの正式な開示請求への対応のみです。') !!}</p>
    </section>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('第三者への提供') !!}</h2>
        <p class="text-sm leading-relaxed">{!! $ruby->addRuby('原則として第三者に提供しません。ただし法的機関からの正式な開示請求があった場合はこの限りではありません。') !!}</p>
    </section>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('お問い合わせ') !!}</h2>
        <p class="text-sm leading-relaxed">{!! $ruby->addRuby('プライバシーに関するお問い合わせは下記まで。返信を保証するものではありません。') !!}<br>contact@shogaisha.wtf（仮）</p>
    </section>

    <hr class="my-10 border-gray-200">

    <h2 class="text-xl font-bold mb-6">{!! $ruby->addRuby('削除ポリシー') !!}</h2>

    <section class="mb-8">
        <h3 class="font-bold mb-2">{!! $ruby->addRuby('削除対象') !!}</h3>
        <p class="text-sm leading-relaxed mb-2">{!! $ruby->addRuby('以下に該当する投稿は管理者の判断により削除します。') !!}</p>
        <ul class="text-sm leading-relaxed list-disc pl-5">
            <li>{!! $ruby->addRuby('特定個人の個人情報の無断掲載') !!}</li>
            <li>{!! $ruby->addRuby('児童への性的表現') !!}</li>
            <li>{!! $ruby->addRuby('スパム・広告目的の投稿') !!}</li>
            <li>{!! $ruby->addRuby('特定個人への誹謗中傷') !!}</li>
            <li>{!! $ruby->addRuby('明らかな荒らし行為') !!}</li>
        </ul>
    </section>

    <section class="mb-8">
        <h3 class="font-bold mb-2">{!! $ruby->addRuby('注意書きの表示') !!}</h3>
        <p class="text-sm leading-relaxed">{!! $ruby->addRuby('不快な表現を含む可能性がある記事には冒頭に以下を表示します。') !!}<br>「この記事には一部の方が不快に感じる表現が含まれる場合があります。」</p>
    </section>

    <section class="mb-8">
        <h3 class="font-bold mb-2">{!! $ruby->addRuby('削除申請') !!}</h3>
        <p class="text-sm leading-relaxed">{!! $ruby->addRuby('削除申請は下記まで。対応を保証するものではありません。') !!}<br>contact@shogaisha.wtf（仮）</p>
    </section>
</main>

@endsection
