@extends('layouts.app')
@section('content')

<main id="main" class="max-w-3xl mx-auto px-4 py-8">

<h3 class="text-2xl font-bold mb-6">ログイン / 新規登録</h3>

<ul class="text-gray-700 mb-8 space-y-2">
    <li class="text-red-500">・登録、投稿は障害者、障害者の家族、支援者、医療・福祉従事者に限ります。</li>
    <li>・メールアドレスだけで登録できます。パスワードはいりません。</li>
    <li>・登録するとすべての記事に書き足すことができます。</li>
    <li>・ログイン状態は30日間保たれます。</li>
</ul>

@if(session('message'))
<p class="text-sm text-gray-800 mb-4">{{ session('message') }}</p>
@endif

<form method="POST" action="{{ route('login.send') }}">
    @csrf
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">メールアドレス</label>
        <input type="email" name="email" id="email" class="w-full border border-gray-300 px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200" placeholder="example@example.com" required>
        @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <div class="mb-6">
        <label class="flex items-start gap-2 cursor-pointer">
            <input type="checkbox" name="agree" id="agree" class="mt-0.5 accent-blue-700" required>
            <span class="text-sm text-gray-700">
                <a href="{{ route('terms') }}" class="text-blue-700 underline hover:opacity-70">利用規約</a>と<a href="{{ route('privacy') }}" class="text-blue-700 underline hover:opacity-70">プライバシーポリシー</a>に同意する
            </span>
        </label>
        @error('agree')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>
    <button type="submit" class="text-sm border border-blue-800 px-4 py-2 text-blue-800 hover:bg-blue-50">ログインリンクを送る</button>
</form>

</main>

@endsection
