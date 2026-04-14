@php
use App\Services\RubyService;
$ruby = new RubyService();
@endphp
@extends('layouts.app')
@section('content')

<main id="main" class="max-w-3xl mx-auto px-4 pt-0 pb-8">
    <p class="text-center text-base leading-relaxed py-12 max-w-xl mx-auto">{!! $ruby->addRuby('shogaisha.') !!}はこの{!! $ruby->addRuby('星') !!}で{!! $ruby->addRuby('障害者') !!}（それに{!! $ruby->addRuby('類') !!}する、handicappedなど）とよばれる{!! $ruby->addRuby('人') !!}たちの{!! $ruby->addRuby('声') !!}のサイトです。</p>
    <nav aria-label="記事メニュー" class="mb-14">
    <ul class="flex flex-col gap-2 sm:flex-row sm:justify-center">
        <li>
            <a href="{{ url('/articles/9') }}" class="block bg-amber-300 border border-amber-400 px-4 py-3 text-center font-bold hover:bg-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-400">
                {!! $ruby->addRuby('このサイトについて') !!}
            </a>
        </li>
        <li>
            <a href="{{ route('articles.create') }}" class="block border border-blue-800 px-4 py-3 text-center hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-800" >
                {!! $ruby->addRuby('新しく記事を作る') !!}
            </a>
        </li>
        <li>
            <a href="{{ route('articles.random') }}" class="block border border-blue-800 px-4 py-3 text-center hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-800">
                ランダムに{!! $ruby->addRuby('読む') !!}
            </a>
        </li>
        <li>
            <a href="{{ route('articles.list') }}" class="block border border-blue-800 px-4 py-3 text-center hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-800">
                {!! $ruby->addRuby('記事一覧') !!}
            </a>
        </li>
    </ul>
</nav>

<!-- 今日の記事 -->
     <section aria-labelledby="new-heading">
            <h2 id="new-heading" class="sr-only">新着記事</h2>

            @foreach($articles as $article)
            <article class="mb-12 border-l-4 border-blue-800 pl-4">
                @if($article->image_path)
                <img src="{{ asset('storage/' . $article->image_path) }}" alt="" class="aspect-video object-cover w-full mb-3">
                @endif
                <h3 class="text-2xl font-bold mb-3">
                    <a href="{{ route('articles.show', $article) }}" class="hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-800">
                         {!! $article->title_ruby !!}
                    </a>
                </h3>
                <p class="text-sm leading-relaxed text-gray-800">
                    {!! $article->excerpt_ruby !!}
                </p>
                <a href="{{ route('articles.show', $article) }}" class="inline-block mt-3 text-xs text-blue-800 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-800">
                    {!! $ruby->addRuby('続きを読む') !!} →<span class="sr-only">（「障がい者」表記について）</span>
                </a>
            </article>
            @endforeach
        </section>

    <!-- 盛り上がっている記事 -->
     <section aria-labelledby="trending-heading" class="mt-16">
            <div class="flex items-baseline justify-between border-t-2 border-amber-300 pt-2 mb-4">
                <h2 id="trending-heading" class="font-bold text-sm">{!! $ruby->addRuby('盛り上がっている記事') !!}</h2>
            </div>

            @foreach($popular as $article)
            <article class="mb-12 border-l-4 border-amber-300 pl-4">
                @if($article->image_path)
                <img src="{{ asset('storage/' . $article->image_path) }}" alt="" class="aspect-video object-cover w-full mb-3">
                @endif
                <h3 class="text-lg font-bold mb-3">
                    <a href="{{ route('articles.show', $article) }}" class="hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-800">
                         {!! $article->title_ruby !!}
                    </a>
                </h3>
                <p class="text-sm leading-relaxed text-gray-800">
                    {!! $article->excerpt_ruby !!}
                </p>
                <a href="{{ route('articles.show', $article) }}" class="inline-block mt-3 text-xs text-blue-800 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-800">
                    {!! $ruby->addRuby('続きを読む') !!} →<span class="sr-only">{{ $article->title }}</span>
                </a>
            </article>
        @endforeach
        </section>

    </main>

@endsection
