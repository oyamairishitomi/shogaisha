@extends('layouts.app')
@section('content')

<main id="main" class="max-w-3xl mx-auto px-4 py-8">
<h1 class="text-3xl font-bold mb-4">記事を投稿する</h1>
<form method="POST" action="{{ route('articles.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">タイトル</label>
        <input type="text" name="title" id="title" class="w-full border border-gray-300 px-3 py-2 rounded-md focus:outline-none focus:ring focus:ring-blue-200" required>
    </div>
    <div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-1">内容</label>
    <input type="hidden" name="body" id="article-body-input">
    <div id="article-toolbar" class="flex flex-wrap gap-1 border border-gray-300 border-b-0 px-2 py-1">
        <button type="button" data-cmd="paragraph" class="toolbar-btn px-2 py-1 text-sm border border-gray-200 hover:bg-gray-100">P</button>
        <button type="button" data-cmd="bold" class="toolbar-btn px-2 py-1 text-sm border border-gray-200 hover:bg-gray-100">B</button>
        <button type="button" data-cmd="italic" class="toolbar-btn px-2 py-1 text-sm border border-gray-200 hover:bg-gray-100 italic">I</button>
        <button type="button" data-cmd="h2" class="toolbar-btn px-2 py-1 text-sm border border-gray-200 hover:bg-gray-100">H2</button>
        <button type="button" data-cmd="h3" class="toolbar-btn px-2 py-1 text-sm border border-gray-200 hover:bg-gray-100">H3</button>
        <button type="button" data-cmd="bulletList" class="toolbar-btn px-2 py-1 text-sm border border-gray-200 hover:bg-gray-100">・リスト</button>
        <button type="button" data-cmd="orderedList" class="toolbar-btn px-2 py-1 text-sm border border-gray-200 hover:bg-gray-100">1. リスト</button>
        <button type="button" id="article-mic-btn" class="toolbar-btn px-2 py-1 text-sm border border-gray-200 hover:bg-gray-100">🎤声で入力する</button>
    </div>
    <div id="article-editor" class="border border-gray-300 px-3 py-2 min-h-48 text-base leading-relaxed"></div>
    </div>
    <div class="mb-4">
        <label for="image" class="inline-block border border-gray-400 px-4 py-1 text-sm cursor-pointer hover:bg-gray-50">
            画像を選ぶ
        </label>
        <input type="file" name="image_path" id="image" class="hidden">
    </div>
    <button type="submit" class="text-sm border border-blue-800 px-4 py-2 text-blue-800 hover:bg-blue-50">投稿する</button>
</form>
</main> 

@endsection