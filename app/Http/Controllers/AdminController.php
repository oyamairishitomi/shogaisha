<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Entry;
use App\Models\User;

class AdminController extends Controller
{
    public function index(){
        $articles = Article::latest()->get();
        $entries = Entry::latest()->with('article')->get();
        return view('admin.index', compact('articles', 'entries'));
    }

    public function destroyArticle(Article $article) {
        $article->delete();
        return back();
    }  
    
    public function destroyEntry(Entry $entry) {
        $entry->delete();
        return back();
    }

    public function users(){
        $users = User::all();
        return view('admin.users', compact('users'));
    }
}
