<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SpeechController;

Route::get('/', [ArticleController::class, 'index'])->name('articles.index');
// トップページ

Route::get('/login', [AuthController::class, 'showForm'])->name('login');
//メアド入力フォームを表示　GETのログインページ
Route::post('/login', [AuthController::class, 'sendLink'])->name('login.send');
//メアドを受け取ってマジックリンクメールを送信
Route::get('/verify/{token}', [AuthController::class, 'verify'])->name('login.verify');
// メールのリンクを踏んだときにトークン検証してログイン

Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create'); 
 // フォーム表示
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
// 保存

Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
Route::patch('articles/{article}', [ArticleController::class, 'update'])->name('articles.update');

Route::post('/articles/{article}/entries', [EntryController::class, 'store'])->name('entries.store');
Route::delete('/entries/{entry}', [EntryController::class, 'destroy'])->name('entries.destroy');

Route::get('/articles/random', [ArticleController::class, 'random'])->name('articles.random');
// ランダムに読む
Route::get('/articles/list', [ArticleController::class, 'list'])->name('articles.list');
// 記事一覧
Route::get('/articles/search', [ArticleController::class, 'search'])->name('articles.search');
//検索
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
// 特定記事

Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
// 投稿した追記に表示される削除

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('ai/ghostwrite', [App\Http\Controllers\AiController::class, 'ghostwrite']);
//Ai代理入力

Route::view('/terms', 'legal.terms')->name('terms');
// 利用規約
Route::view('/privacy', 'legal.privacy')->name('privacy');
// プライバシーポリシー

// ------------------------------

Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']); //管理画面トップ
    Route::delete('/articles/{article}', [AdminController::class, 'destroyArticle']);
    Route::delete('/entries/{entry}', [AdminController::class, 'destroyEntry'])->name('admin.entries.destroy');
    Route::get('/users', [AdminController::class, 'users']); //ユーザー一覧
});

// ------------------------------

Route::post('/api/speech', [SpeechController::class, 'transcribe'])->name('speech.transcribe');

// ------------------------------