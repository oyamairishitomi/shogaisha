@extends('layouts.app')
@section('content')

<main class="max-w-3l mx-auto px-4 py-8">
    <h1 class="text-xl font-bold mb-4">「{{ $q }}」の検索結果</h1>

    @forelse($articles as $article)
        <div class="mb-6">
            <a href="{{ route('articles.show', $article) }}" class="text-lg font-bold text-blue-800 hover:underline">
                {{ $article->title }}
            </a>
            <p class="text-sm text-gray-600 mt-1">{{ Str::limit(strip_tags($article->body), 80) }}</p>
        </div>
    @empty
        <p class="text-gray-500">記事が見つかりませんでした</p>
    @endforelse
</main>

@endsection