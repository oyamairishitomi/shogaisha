<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use App\Models\User;
use App\Models\Article;

class AuthController extends Controller
{
    public function showForm(){
        return view('login.login');
    }

    public function sendLink(Request $request){
        $request->validate([
            'email' => 'required|email',
            'agree' => 'accepted',
        ], [
            'email.required' => '入力してください',
            'agree.accepted' => '同意のない場合登録できません。',
        ]);

        $user = User::firstOrCreate(
            ['email' => $request->email],
            ['handle_name' => '名無し']
            );

        $token = bin2hex(random_bytes(32));

        Token::create([
            'user_id' => $user->id, //<-user_idで保存
            'token' => $token,
            'expires_at' => now()->addMinutes(60)
        ]);

        $user->notify(new \App\Notifications\MagicLinkNotification($token));
            // newはクラスのインスタンスを作るときの。
            // $user->notify(なにか)　でユーザーに通知を送る。
            // Userモデルに入っている
        
        return view('login.sent');
        //メールを送りましたページを表示
    }

    public function verify(Request $request, $token){
        $magicLink = Token::where('token', $token)->firstOrFail();
        // URLのクエリパラメータ（?token=xxx）からトークンを取り出してDBで検索。見つからなければ404。
        if ($magicLink->expires_at->isPast()){
            abort(403, 'このリンクは期限切れです');
        }
        $user = User::findOrFail($magicLink->user_id);
        //マジックリンクに紐付いたメールアドレスでユーザーを検索。見つからなければ404。
        auth()->login($user);
        $magicLink->delete();
        $user->update(['ip_address' => $request->ip()]);

        if (session('pending_entry')) {
            $pending = session()->pull('pending_entry');
            $article = Article::find($pending['article_id']);
            $entry = $article->entries()->create([
                'body' => $pending['body'],
                'type' => $pending['type'],
                'use_ai' => false,
            ]);
            $entry->user()->associate($user);
            $entry->save();
            return redirect()->route('articles.show', $article);
        }

        return redirect('/');
    }

    public function logout() {
        auth()->logout();
        return redirect('/');
    }

}