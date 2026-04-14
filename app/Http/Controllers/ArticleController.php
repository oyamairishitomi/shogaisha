<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Services\RubyService;

class ArticleController extends Controller
{
    public function index(){
        $ruby = new RubyService();

        $articles = Article::latest()->take(10)->get()->map(function ($article) use ($ruby) {
            $article->title_ruby = cache()->remember("article_title_ruby_{$article->id}", now()->addDays(30), fn() => $ruby->addRuby($article->title));
            $article->excerpt_ruby = cache()->remember("article_excerpt_ruby_{$article->id}", now()->addDays(30), fn() => $ruby->addRuby(Str::limit(strip_tags($article->body), 100)));
            return $article;
        });
        $popular = Article::select('articles.*',
                DB::raw('LENGTH(articles.body) + COALESCE(SUM(LENGTH(entries.body)), 0) as total_chars')
            )
            ->leftJoin('entries', 'entries.article_id', '=', 'articles.id')
            ->groupBy('articles.id')
            ->orderByDesc('total_chars')
            ->take(3)
            ->get()->map(function ($article) use ($ruby){
                $article->title_ruby = cache()->remember("article_title_ruby_{$article->id}", now()->addDays(30), fn() => $ruby->addRuby($article->title));
                $article->excerpt_ruby = cache()->remember("article_excerpt_ruby_{$article->id}", now()->addDays(30), fn() => $ruby->addRuby(Str::limit(strip_tags($article->body), 100)));

                return $article;
            });
        return view('articles.index', compact('articles', 'popular'));
    }

    public function list(Request $request){
        $ruby = new RubyService();
        $articles = Article::latest()->paginate(20); //最新順で20件ずつ区切って取る。何ページかの情報も持つ

        $articles->getCollection()->transform(function ($article) use ($ruby) {
            $article->title_ruby = cache()->remember("article_title_ruby_{$article->id}", now()->addDays(30), fn() => $ruby->addRuby($article->title));
            $article->excerpt_ruby = cache()->remember("article_excerpt_ruby_{$article->id}", now()->addDays(30), fn() => $ruby->addRuby(Str::limit(strip_tags($article->body), 100)));
            return $article;
        });

        if ($request->ajax()) { //JSの非同期リクエストかどうか判定。JSからfetch()で叩いた場合はtrue
            return response()->json([ //Ajaxのときだけ実行。
                'html' => view('articles._item',compact('articles'))->render(), //BladeをHTMLの文字列に変換して次ページのURLとともにJSONで返す
                'next_page' => $articles->nextPageUrl(),
            ]);
        }

        return view('articles.list', compact('articles')); //普通のアクセスの時
    }

    public function search(Request $request) {
        $q = $request->input('q');
        $articles = Article::where('title', 'LIKE', "%{$q}%")
            ->orWhere('body', 'LIKE', "%{$q}%")
            ->latest()
            ->get();

        return view('articles.search', compact('articles', 'q'));
    }

    public function show(Article $article) {
        $article->load('entries');
        $ruby = new \App\Services\RubyService();

        $bodyRuby = cache()->remember("article_ruby_{$article->id}", now()->addDays(30), function () use ($article, $ruby) {
            return $ruby->addRuby($article->body);
        });

        $entriesRuby = $article->entries->map(function ($entry) use ($ruby) {
            $entry->body_ruby = cache()->remember("entry_ruby_{$entry->id}", now()->addDays(30), function () use ($entry, $ruby) {
                return $ruby->addRuby($entry->body);
            });
            return $entry;
        });
        return view('articles.show', compact('article', 'bodyRuby', 'entriesRuby'));
    }

    public function random(){
        $article = Article::inRandomOrder()->first();
        if (!$article) return redirect()->route('articles.index');
        return redirect()->route('articles.show', $article);
    }

    public function create(){
        return view('articles.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            ['title' => 'required|string|max:255',
            'body' => 'required'],
            ['title.required' => 'タイトルが不適切です',
            'body.required' => '内容が未記入です'],
        );

        $imagePath = null;

        if ($request->hasFile('image_path')){
            $imagePath = $request->file('image_path')->store('image_path','public');
        }

        $article = new Article([
            'title' => $request->title,
            'body' => $request->body,
            'image_path' => $imagePath,
        ]);

        $article->user()->associate(auth()->user());
        $article->save();

        return redirect()->route('articles.index');
    }

    public  function edit(Article $article) {
        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article) {
        $request->validate(
            ['title' => 'required|string|max:255',
            'body' => 'required'],
            ['title.required' => 'タイトルが不適切です',
            'body.required' => '内容が未記入です'],
        );

        $imagePath = $article->image_path;

        if ($request->boolean('delete_image')) {
            $imagePath = null;
        }

        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('image_path', 'public');
        }

        if ($request->hasFile('image_path')){
            $imagePath = $request->file('image_path')->store('image_path','public');
        }
        
        $article->update([
            'title' => $request->title,
            'body' => $request->body,
            'image_path' => $imagePath,
        ]);

        cache()->forget("article_ruby_{$article->id}");
        cache()->forget("article_title_ruby_{$article->id}");
        cache()->forget("article_excerpt_ruby_{$article->id}");

        return redirect()->route('articles.show', $article);
    }

    public function destroy(Article $article): RedirectResponse
    {
        if (auth()->id() !== $article->user_id) abort(403);
        $article->delete();
        return redirect()->route('articles.index');
    }
}
