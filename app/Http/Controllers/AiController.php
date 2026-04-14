<?php

namespace App\Http\Controllers;

use App\Ai\Agents\GhostwriterAgent;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function ghostwrite(Request $request)
    {
        $draft = $request->input('draft');
        // フロントから送られてくる断片メモを受け取る　フォームにdraft

        return (new GhostwriterAgent)->stream($draft);
        // 1.Agentを作る 2.チャンク単位で流れてくる。フロントのJSが受け取る。
    }
}
