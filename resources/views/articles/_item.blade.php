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
                    続きを読む →<span class="sr-only">{{ $article->title }}</span>
                </a>
            </article>
            @endforeach