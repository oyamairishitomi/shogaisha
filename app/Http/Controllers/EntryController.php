<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Entry;

class EntryController extends Controller
{
    public function store(Request $request, Article $article){
        if (!auth()->check()) {
            session(['pending_entry' => [
                'body' => $request->body,
                'type' => $request->type,
                'article_id' => $article->id,
            ]]);
            return redirect()->route('login')->with('message','投稿するにはログインが必要です。テキストは残っているので安心してね！');
        }

        $request->validate([
            'body' => 'required',
            'type' => 'nullable',
            'use_ai' => 'boolean',
        ],[
            'body' => '本文を入力してください。',
            'type' =>  'ぼやきの種類を選んでください。'
        ]);

        $purifier = new \HTMLPurifier(\HTMLPurifier_Config::createDefault());
        $cleanBody = $purifier->purify($request->body);

        $entry = $article->entries()->create([
            'body' => $cleanBody,
            'type' => $request->type,
            'use_ai' => $request->use_ai ?? false
        ]);

        $entry->user()->associate(auth()->user());
        $entry->save();

        cache()->forget("entry_ruby_{$entry->id}");

        return redirect()->route('articles.show', $article);
    }

    public function destroy(Entry $entry)
    {
        if (auth()->id() !== $entry->user_id && auth()->user()->authority !== 0) {
            abort(403);
        }
        $entry->delete();
        return redirect()->route('articles.index');
    }
}