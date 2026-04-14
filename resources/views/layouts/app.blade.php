<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>shogaisha. - 百科事典とぼやきのホームページ</title>
        <script>window.ghostwriteUrl = '{{ url('/ai/ghostwrite') }}';</script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Kaisei+Opti&family=BIZ+UDGothic&family=BIZ+UDPGothic&family=Noto+Sans+JP&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script src="https://cdn.tailwindcss.com?plugins=typography"></script>
        <script>
        tailwind.config = {
            theme: {
            extend: {
                fontFamily: {
                sans: ['BIZ UDGothic', 'BIZ UDPGothic', 'Noto Sans JP', 'sans-serif'],
            }
            }
            }
        }
        </script>
        </head>
<body class="font-sans bg-stone-50">
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:top-2 focus:left-2 focus:bg-white focus:border focus:border-blue-800 focus:px-4 focus:py-2"
    >
        メインコンテンツへスキップ
    </a>

    <header>
        <div class="bg-blue-900">
            <nav aria-label="アカウントメニュー" class="max-w-3xl mx-auto px-4 py-2 flex flex-wrap gap-2 justify-end items-center">
<form action="{{ route('articles.search') }}" method="GET" class="flex">
                <input type="text" name="q" placeholder="検索" class="text-sm px-2 py-1 w-16 sm:w-28 bg-blue-800 text-white placeholder-blue-300 border border-blue-600 focus:outline-none focus:border-white">
                <button type="submit" class="text-sm px-2 py-1 text-blue-200 border border-blue-600 border-l-0 hover:text-white hover:border-white transition-colors">🔍</button>
            </form>
            <input type="checkbox" id="ruby-switch" class="sr-only" checked>
            <label for="ruby-switch" class="cursor-pointer flex items-center gap-2 text-white text-sm shrink-0">
                <span class="relative inline-block w-10 h-5 bg-gray-500 rounded-full shrink-0">
                    <span class="ruby-knob absolute top-0.5 left-0.5 w-4 h-4 bg-white rounded-full transition-all"></span>
                </span>
                ふりがな
            </label>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-white text-sm px-4 py-2 border border-white hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900">ログアウト</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="text-blue-900 text-sm bg-amber-300 px-4 py-2 hover:bg-amber-400 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-900">ログイン / 新規登録</a>
                @endauth
            </nav>
        </div>
        <div class="bg-blue-900">
            <h1 class="sr-only">shogaisha. 百科事典とぼやきのホームページ</h1>
            <a href="{{ url('/') }}" class="block text-center text-[18vw] font-bold text-white [font-family:'Kaisei_Opti',serif]" aria-label="しょうがいしゃ">shogaisha.</a>
            <p class="text-center text-white pb-4 text-2xl font-bold" style="font-family: 'Hiragino Mincho ProN', 'Yu Mincho', serif;">しょうがいしゃ.</p>
        </div>
    </header>

@yield('content')

    <footer>
        <p class="text-sm text-center leading-relaxed py-12 max-w-xl mx-auto">© 2025 shogaisha.　<a href="{{ route('terms') }}" class="hover:underline">利用規約</a>　<a href="{{ route('privacy') }}" class="hover:underline">プライバシーポリシー</a></p>
    </footer>

</body>
</html>
