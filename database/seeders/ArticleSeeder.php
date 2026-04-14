<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Article;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Article::create([
            'title' => '障害者雇用について',
            'body' => '　障害者雇用とは、企業のブランディングに障害者を利用し、ダイバーシティなどの横文字を並べて低賃金で障害者に代替可能な業務をやらせる現代の奴隷労働である。'
        ]);

        Article::create([
            'title' => '就労移行支援事業所について',
            'body' => '　就労移行支援事業所とは、障害者を所定の期間中原則施設内に座らせておくだけで国からお金がもらえるシステムである。'
        ]);

        Article::create([
            'title' => '障がい者という表記について',
            'body' => '　障がい者とは、害の字はねえだろなどの健常者側の配慮（笑）によってあえてひらがなになった表記である。正直どっちでもいいのが筆者の気持ちである。'
        ]);
    }
}
