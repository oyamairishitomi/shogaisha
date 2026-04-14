<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

class GhostwriterAgent implements Agent //これはAIエージェントですという宣言
{
    use Promptable; // .prompt()や.streams()が使えるようになる

    public function instructions(): Stringable|string //毎回のリクエストに自動で先頭につく。このエージェントの役割
    {
        return '箇条書きや断片的なメモを、投稿できる自然な日本語の文章に整形してください。';
    }
}
