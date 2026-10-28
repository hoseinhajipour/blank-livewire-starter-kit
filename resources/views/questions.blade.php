@extends('layouts.app')

@section('content')
<section class="page-hero compact"><div class="container"><span class="eyebrow">پاسخ از زبان پزشک</span><h1>پرسش و پاسخ دندانپزشکی</h1><p>سوال خود را درباره خدمات مطب بپرسید؛ پاسخ پس از بررسی پزشک در همین صفحه منتشر می‌شود.</p></div></section>

<section class="section"><div class="container questions-layout"><div><div class="ask-card"><div><span class="eyebrow">سوال جدید</span><h2>چیزی ذهنتان را مشغول کرده؟</h2></div><a class="btn btn-dark" href="#question-form">پرسش خود را بنویسید</a></div>
<div class="questions-list" id="published-questions">
  @forelse($publishedQuestions as $question)
    <article class="question-card" data-question="{{ $question['question'] }} {{ $question['answer'] }} {{ $question['tag'] }}"><span class="tag">{{ $question['tag'] }}</span><h3>{{ $question['question'] }}</h3><p>{{ $question['answer'] }}</p><small>پاسخ پزشک · {{ $question['date'] }}</small></article>
  @empty
    <div class="empty-related">هنوز پاسخ تأییدشده‌ای منتشر نشده است.</div>
  @endforelse
</div></div>
<aside class="question-side"><div class="search-box"><span>⌕</span><input id="question-search" placeholder="جستجو در پرسش‌ها" aria-label="جستجو در پرسش‌ها"></div><h4>خدمات</h4>@foreach($services as $service)<a href="{{ route('service.show', $service['slug']) }}">{{ $service['title'] }} <b>←</b></a>@endforeach</aside></div></section>

<section class="section form-section" id="question-form"><div class="container narrow"><span class="eyebrow">ارسال پرسش</span><h2>سوالتان را برای ما بنویسید</h2><p class="form-intro">پرسش شما ابتدا توسط پزشک بررسی می‌شود و پس از تأیید، پاسخ آن برای استفاده دیگر مراجعه‌کنندگان منتشر خواهد شد.</p><livewire:question-form /></div></section>
@push('scripts')
<script>
document.getElementById('question-search')?.addEventListener('input', function () {
    const query = this.value.trim().toLowerCase();
    document.querySelectorAll('#published-questions .question-card').forEach(card => {
        card.hidden = query && !card.dataset.question.toLowerCase().includes(query);
    });
});
</script>
@endpush
@endsection


