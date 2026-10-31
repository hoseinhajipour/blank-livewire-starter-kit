@php
    $active = fn (string ...$patterns): string => request()->routeIs(...$patterns) ? 'is-active' : '';
@endphp
<header class="site-header">
  <div class="topline"><div class="container top-inner"><span>شنبه تا چهارشنبه · صبح و عصر</span><span><a href="tel:02626545747">۰۲۶۲۶۵۴۵۷۴۷</a> · <a href="tel:02626551835">۰۲۶۲۶۵۵۱۸۳۵</a> · <a href="tel:09013987065">۰۹۰۱۳۹۸۷۰۶۵</a></span></div></div>
  <div class="container nav-wrap">
    <a class="brand" href="{{ route('home') }}"><img src="{{ asset('images/logo-wide.webp') }}" alt="مطب دکتر حسینی"><span>مطب دکتر حسینی</span></a>
    <button class="menu-toggle" id="menu-toggle" aria-label="باز کردن منو"><span></span><span></span><span></span></button>
    <nav class="main-nav" id="main-nav" aria-label="منوی اصلی">
      <a class="{{ $active('home') }}" @if(request()->routeIs('home')) aria-current="page" @endif href="{{ route('home') }}">خانه</a>
      <a class="{{ $active('services', 'service.show') }}" @if(request()->routeIs('services', 'service.show')) aria-current="page" @endif href="{{ route('services') }}">خدمات</a>
      <a class="{{ $active('articles', 'article.show') }}" @if(request()->routeIs('articles', 'article.show')) aria-current="page" @endif href="{{ route('articles') }}">مجله سلامت</a>
      <a class="{{ $active('questions') }}" @if(request()->routeIs('questions')) aria-current="page" @endif href="{{ route('questions') }}">پرسش و پاسخ</a>
      <a class="{{ $active('about') }}" @if(request()->routeIs('about')) aria-current="page" @endif href="{{ route('about') }}">درباره پزشک</a>
      <a class="{{ $active('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif href="{{ route('contact') }}">تماس با ما</a>
      <a class="nav-cta {{ $active('contact') }}" @if(request()->routeIs('contact')) aria-current="page" @endif href="{{ route('contact') }}">رزرو نوبت <span>←</span></a>
    </nav>
  </div>
</header>


