@php
use App\Services\RubyService;
$ruby = new RubyService();
@endphp
@extends('layouts.app')
@section('content')

<main id="main" class="max-w-3xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-bold mb-8">利用規約</h1>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('第1条（サービスの目的）') !!}</h2>
        <p class="text-sm leading-relaxed">{!! $ruby->addRuby('shogaishaは、障害者およびその関係者が匿名で経験・意見・ぼやきを共有するためのプラットフォームです。') !!}</p>
    </section>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('第2条（利用資格）') !!}</h2>
        <p class="text-sm leading-relaxed mb-2">{!! $ruby->addRuby('本サービスへの投稿は、以下のいずれかに該当する方に限ります。') !!}</p>
        <ul class="text-sm leading-relaxed list-disc pl-5">
            <li>{!! $ruby->addRuby('障害者本人') !!}</li>
            <li>{!! $ruby->addRuby('障害者の家族') !!}</li>
            <li>{!! $ruby->addRuby('支援者') !!}</li>
            <li>{!! $ruby->addRuby('医療・福祉従事者') !!}</li>
        </ul>
        <p class="text-sm leading-relaxed mt-2">{!! $ruby->addRuby('上記は自己申告によるものとします。虚偽申告が判明した場合、投稿の削除およびアカウント停止の対象となります。') !!}</p>
    </section>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('第3条（投稿内容の責任）') !!}</h2>
        <p class="text-sm leading-relaxed">{!! $ruby->addRuby('投稿内容の責任は投稿者本人に帰属します。当サービスは投稿内容の真偽・正確性について一切の責任を負いません。') !!}</p>
    </section>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('第4条（禁止事項）') !!}</h2>
        <p class="text-sm leading-relaxed mb-2">{!! $ruby->addRuby('以下の投稿は禁止します。') !!}</p>
        <ul class="text-sm leading-relaxed list-disc pl-5">
            <li>{!! $ruby->addRuby('特定個人の個人情報の無断掲載') !!}</li>
            <li>{!! $ruby->addRuby('児童への性的表現') !!}</li>
            <li>{!! $ruby->addRuby('スパム・広告目的の投稿') !!}</li>
            <li>{!! $ruby->addRuby('虚偽の属性申告による投稿') !!}</li>
            <li>{!! $ruby->addRuby('特定個人への誹謗中傷') !!}</li>
        </ul>
    </section>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('第5条（IPアドレスの記録）') !!}</h2>
        <p class="text-sm leading-relaxed">{!! $ruby->addRuby('本サービスはすべての投稿者のIPアドレスを記録します。法的機関からの正式な開示請求があった場合、これに応じる場合があります。') !!}</p>
    </section>

    <section class="mb-8">
        <h2 class="font-bold mb-2">{!! $ruby->addRuby('第6条（免責事項）') !!}</h2>
        <p class="text-sm leading-relaxed">{!! $ruby->addRuby('本サービスの利用によって生じたいかなる損害についても、当サービスは責任を負いません。') !!}</p>
    </section>
</main>

@endsection
