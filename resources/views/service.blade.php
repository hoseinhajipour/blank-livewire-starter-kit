@extends('layouts.app')

@section('content')
@php
    $item = collect($services)->firstWhere('slug', $service) ?? $services[0];
    $relatedQuestions = collect($questions ?? [])->where('service', $item['slug'])->take(4);
    $relatedArticles = collect($articles ?? [])->filter(fn (array $article): bool => in_array($item['slug'], $article['services'] ?? [], true));
@endphp

<section class="page-hero compact service-detail-hero"><div class="container"><a class="back-link" href="{{ route('services') }}">→ همه خدمات</a><span class="eyebrow">خدمت تخصصی</span><h1>{{ $item['title'] }}</h1><p>{{ $item['desc'] }}</p></div></section>

<section class="section"><div class="container detail-grid"><article class="prose">@if(!empty($item['content'])){!! $item['content'] !!}@else<h2>درمان با برنامه‌ای روشن</h2><p>در جلسه مشاوره، شرایط دهان و دندان شما با دقت بررسی می‌شود و همه مراحل، زمان‌بندی و مراقبت‌های لازم به زبان ساده توضیح داده خواهد شد. هدف ما درمانی ماندگار، طبیعی و هماهنگ با سلامت کلی شماست.</p><h3>چه چیزی انتظار داشته باشید؟</h3><ul><li>معاینه و بررسی دقیق شرایط</li><li>توضیح گزینه‌های درمانی و انتخاب آگاهانه</li><li>پیگیری و مراقبت بعد از درمان</li></ul>@endif</article><aside class="detail-aside"><img class="detail-service-image" src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}"><h3>برای مشاوره آماده‌اید؟</h3><p>با ما تماس بگیرید تا زمان مناسب را پیدا کنیم.</p><a class="btn btn-gold" href="{{ route('contact') }}">رزرو نوبت <span>←</span></a></aside></div></section>

<section class="section related-service-section"><div class="container"><div class="section-head"><div><span class="eyebrow">پرسش‌های مرتبط</span><h2>آخرین سوالات درباره {{ $item['title'] }}</h2></div><a class="text-link" href="{{ route('questions') }}">همه پرسش‌ها <span>←</span></a></div>@if($relatedQuestions->isNotEmpty())<div class="service-question-grid">@foreach($relatedQuestions as $question)<article class="service-question-card"><span class="tag">{{ $question['tag'] }}</span><h3>{{ $question['question'] }}</h3><p>{{ $question['answer'] }}</p><small>پاسخ پزشک · {{ $question['date'] }}</small></article>@endforeach</div>@else<div class="empty-related">هنوز پرسش مرتبطی برای این خدمت ثبت نشده است.</div>@endif</div></section>

<section class="section related-articles-section"><div class="container"><div class="section-head"><div><span class="eyebrow">مطالعه بیشتر</span><h2>مقالات مرتبط با این خدمت</h2></div><a class="text-link" href="{{ route('articles') }}">مشاهده مجله سلامت <span>←</span></a></div>@if($relatedArticles->isNotEmpty())<div class="article-grid related-article-grid">@foreach($relatedArticles as $article)<a class="article-card" href="{{ route('article.show', $article['slug']) }}"><img src="{{ asset($article['image']) }}" alt="{{ $article['title'] }}"><div class="article-body"><span>{{ $article['category'] }} · {{ $article['date'] }}</span><h3>{{ $article['title'] }}</h3><b>مطالعه مطلب ←</b></div></a>@endforeach</div>@else<div class="empty-related">مقاله مرتبطی برای این خدمت منتشر نشده است.</div>@endif</div></section>
@endsection


