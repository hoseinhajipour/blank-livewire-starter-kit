@extends('layouts.app') @section('content')
<livewire:hero-section />
<livewire:service-showcase />
<section class="section clinic-story"><div class="container story-grid"><div class="story-image doctor-story-image"><img src="{{ asset('images/photo_5976571529715716028_y.webp') }}" alt="دکتر اشرف سادات حسینی، جراح دندانپزشک"><span>دکتر اشرف سادات حسینی<br><small>جراح‌دندانپزشک</small></span></div><div class="story-copy"><span class="eyebrow">چرا دکتر حسینی؟</span><h2>علم دقیق، ارتباط صمیمی</h2><p>از اولین گفت‌وگو تا پایان درمان، شما فقط یک مراجعه‌کننده نیستید؛ عضوی از خانواده مطب هستید. رویکرد ما ترکیبی از دانش به‌روز، توضیح شفاف و محیطی است که اضطراب را از تجربه دندانپزشکی دور می‌کند.</p><div class="check-list"><span>✓ تشخیص و درمان با توضیح شفاف</span><span>✓ توجه ویژه به کودکان و خانواده‌ها</span><span>✓ برنامه درمانی متناسب با شرایط شما</span></div><a class="text-link" href="{{ route('about') }}">بیشتر درباره پزشک <span>←</span></a></div></div></section>
<livewire:gallery-carousel />
<livewire:faq-preview />
<section class="section article-section"><div class="container">@include('partials.section-title',['eyebrow'=>'مجله سلامت','heading'=>'آخرین مطالب برای لبخندی سالم','link'=>route('articles')])<div class="article-grid">@foreach($articles as $article)<a class="article-card" href="{{ route('article.show',$article['slug']) }}"><img src="{{ asset($article['image']) }}" alt="{{ $article['title'] }}"><div class="article-body"><span>{{ $article['category'] }} · {{ $article['date'] }}</span><h3>{{ $article['title'] }}</h3><b>ادامه مطلب ←</b></div></a>@endforeach</div></div></section>
@endsection


