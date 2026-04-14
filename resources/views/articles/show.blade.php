@extends('layouts.app')
@section('content')

<main id="main" class="max-w-3xl mx-auto px-4 py-8">

{{-- 記事 --}}
@if($article->image_path)
<img src="{{ asset('storage/'. $article->image_path) }}" alt="" class="w-full mb-6">
@endif
<h1 class="text-3xl font-bold mb-4">{{ $article->title }}</h1>
    @if(auth()->id() === $article->user_id)
    <div class="flex justify-end gap-2 mb-6">
        <a href="{{ route('articles.edit', $article) }}" class="text-sm border border-blue-800 px-4 py-1 text-blue-800 hover:bg-blue-50">書き換える</a>
        <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="text-sm border border-gray-400 px-4 py-1 text-gray-600 hover:bg-gray-50">消す</button>
        </form>
    </div>
    @endif
<div class="prose max-w-none text-base text-gray-900 leading-relaxed mb-8">{!! $bodyRuby !!}</div>
{{-- entry列挙 --}}
@forelse($entriesRuby as $entry)
<div class="mb-4 text-base text-gray-900 leading-relaxed">
    {!! $entry->body_ruby !!}
    @if($entry->user)
    <span class="text-sm text-gray-500 ml-2" style="white-space: nowrap;">— {{ $entry->user->handle_name }}</span>
    @endif
    @if($entry->type)
    <span class="text-xs text-blue-800 border border-blue-800 px-2 ml-1" style="white-space: nowrap;">{{ $entry->type }}</span>
    @endif
    @if(auth()->id() === $entry->user_id)
    <form action="{{ route('entries.destroy', $entry) }}" method="POST" class="inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-xs text-gray-400 ml-2">消す</button>
    </form>
    @endif
</div>
@empty
@endforelse


{{-- entryフォーム --}}
<form method="POST" action="{{ route('entries.store', $article) }}">
    @csrf
    <input type="hidden" name="body" id="body-input">
    <input type="hidden" name="use_ai" id="use-ai-input" value="0">
    <div id="editor-wrapper" class="relative">
        <span class="cursor absolute top-0 left-0 select-none pointer-events-none text-2xl text-gray-900">|</span>
        <div id="editor" class="text-base leading-relaxed outline-none min-h-8"></div>
    </div>    

    <div class="mt-4 flex gap-2">
        <select name="type" class="text-sm border border-gray-300 px-2 py-1">
            <option value="">タグなし</option>
            <option value="反論">反論</option>
            <option value="わかる">わかる</option>
            <option value="ぼやき">ぼやき</option>
        </select>
        <button type="submit" id="submit-btn" class="text-sm border border-blue-800 px-4 py-1 text-blue-800 hover:bg-blue-50">ぼやく</button>
        <button type="button" id="open-ai-btn" class="text-sm border border-gray-400 px-4 py-1 text-gray-600 hover:bg-gray-50">AI代筆</button>
        <button type="button" id="mic-btn" class="text-sm border border-gray-400 px-4 py-1 text-gray-600 hover:bg-gray-50">🎤声で入力する</button>
    </div>
</form>

</main>

<div id="ai-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
    <div id="ai-modal" class="bg-white w-full max-w-xl mx-auto mt-24 p-6">
        <p class="text-sm text-gray-800 mb-2">断片メモからAIで文章を作れます</p>
        <textarea id="draft-input" rows="4" class="w-full border border-gray-300 px-4 py-2 text-sm mb-3" placeholder="例：バスに乗りづらい、誰も助けない、職場でいいことがあった"></textarea>
        <div id="ai-result" class="min-h-24 text-base leading-relaxed border border-gray-200 p-3 mb-3 hidden"></div>
        <div class="flex gap-2">
            <button type="button" id="ghostwrite-btn" class="text-sm border border-gray-600 px-4 py-1 hover:bg-gray-50">文章にする</button>
            <button type="button" id="apply-btn" class="text-sm border border-blue-800 px-4 py-1 text-blue-800 hover:bg-blue-50 hidden">これでOK</button>
            <button type="button" id="close-modal-btn" class="text-sm text-gray-400 ml-auto">閉じる</button>
        </div>
    </div>
</div>

@endsection