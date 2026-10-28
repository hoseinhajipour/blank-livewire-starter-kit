@extends('layouts.app')

@section('content')
@php
    $item = collect($articles)->firstWhere('slug', $article) ?? $articles[0];
    $content = $articleContent[$item['slug']] ?? $articleContent['prevention'];
@endphp

<section class="page-hero compact">
    <div class="container">
        <a class="back-link" href="{{ route('articles') }}">→ بازگشت به مجله</a>
        <span class="eyebrow">{{ $item['category'] }} · {{ $item['date'] }}</span>
        <h1>{{ $item['title'] }}</h1>
        <p>{{ $content['intro'] }}</p>
    </div>
</section>

<section class="section">
    <div class="container article-detail">
        <img class="detail-cover" src="{{ asset($item['image']) }}" alt="{{ $item['title'] }}">
        <div class="detail-content">
            <aside class="toc" aria-label="فهرست مطالب">
                <b>فهرست مطالب</b>
                @foreach($content['sections'] as $index => $section)
                    <a href="#section-{{ $index + 1 }}">{{ $section['title'] }}</a>
                @endforeach
                <a href="#faq">سوالات متداول</a>
            </aside>

            <article class="prose">
                @if(!empty($item['content']))
                    {!! $item['content'] !!}
                @else
                    <p class="lead">{{ $content['intro'] }}</p>
                    @foreach($content['sections'] as $index => $section)
                        <section id="section-{{ $index + 1 }}">
                            <h2>{{ $section['title'] }}</h2>
                            @foreach($section['paragraphs'] as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </section>
                    @endforeach
                @endif

                <section class="article-links">
                    <span class="eyebrow">ارجاع‌های مرتبط</span>
                    <h3>برای قدم بعدی، این صفحات را ببینید</h3>
                    <p>برای انتخاب آگاهانه‌تر، توضیحات خدمات و پاسخ‌های تأییدشده پزشک را هم مطالعه کنید.</p>
                    <div class="related-links">
                        <a href="{{ route('services') }}">مشاهده همه خدمات ←</a>
                        <a href="{{ route('service.show', 'root-canal') }}">درمان ریشه ←</a>
                        <a href="{{ route('service.show', 'cosmetic') }}">دندانپزشکی زیبایی ←</a>
                        <a href="{{ route('service.show', 'pediatric') }}">دندانپزشکی کودکان ←</a>
                        <a href="{{ route('questions') }}">پرسش و پاسخ‌های متداول ←</a>
                    </div>
                </section>

                <section class="faq-block" id="faq">
                    <span class="eyebrow">پاسخ‌های کوتاه</span>
                    <h2>سوالات متداول</h2>
                    @foreach($content['faq'] as $faq)
                        <details>
                            <summary>{{ $faq['q'] }}</summary>
                            <p>{{ $faq['a'] }}</p>
                        </details>
                    @endforeach
                </section>
            </article>
        </div>
    </div>
</section>
@endsection


