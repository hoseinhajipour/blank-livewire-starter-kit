<!doctype html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $seo['title'] ?? ($title ?? ($siteSettings->site_title ?? 'مطب دندانپزشکی دکتر حسینی')) }}</title>
  <meta name="description" content="{{ $seo['description'] ?? ($siteSettings->meta_description ?? $siteSettings->site_description ?? 'مطب دندانپزشکی دکتر اشرف سادات حسینی؛ زیبایی، اطفال و درمان ریشه در لواسان') }}">
  <meta name="robots" content="index,follow,max-image-preview:large">
  <meta name="author" content="دکتر اشرف سادات حسینی">
  <meta name="keywords" content="دندانپزشکی لواسان, درمان ریشه, دندانپزشکی کودکان, دندانپزشکی زیبایی, دکتر حسینی">
  <link rel="canonical" href="{{ url()->current() }}">
  <meta property="og:locale" content="fa_IR">
  <meta property="og:type" content="{{ $seo['type'] ?? 'website' }}">
  <meta property="og:title" content="{{ $seo['title'] ?? 'مطب دندانپزشکی دکتر حسینی' }}">
  <meta property="og:description" content="{{ $seo['description'] ?? 'خدمات تخصصی دندانپزشکی در لواسان' }}">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:site_name" content="{{ $siteSettings->site_title ?? 'مطب دندانپزشکی دکتر حسینی' }}">
  <meta property="og:image" content="{{ $seo['image'] ?? asset('images/icon.webp') }}">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="{{ $seo['title'] ?? 'مطب دندانپزشکی دکتر حسینی' }}">
  <meta name="twitter:description" content="{{ $seo['description'] ?? 'خدمات تخصصی دندانپزشکی در لواسان' }}">
  <meta name="twitter:image" content="{{ $seo['image'] ?? asset('images/icon.webp') }}">
  <link rel="alternate" type="text/plain" href="{{ route('llms') }}" title="LLM-readable site summary">
  <script type="application/ld+json">@json($structuredData ?? [])</script>
  @if (!empty($faqSchema))<script type="application/ld+json">@json($faqSchema)</script>@endif
  <script type="application/ld+json">@json($siteSchema ?? [])</script>
  <link rel="icon" href="{{ $siteSettings?->favicon_path ? asset('storage/'.$siteSettings->favicon_path) : asset('images/icon.webp') }}">
  @livewireStyles
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="site-body">
  @include('partials.header')
  <main>@yield('content')</main>
  @include('partials.footer')
  @stack('scripts')
  @livewireScripts
</body>
</html>


