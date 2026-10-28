<section class="section faq-preview faq-library" wire:ignore>
    <div class="container faq-library-grid">
        <div class="faq-library-content">
            <div class="section-head"><div><span class="eyebrow">پرسش و پاسخ</span><h2>آخرین پاسخ‌های پزشک</h2></div><a class="text-link" href="{{ route('questions') }}">مشاهده همه <span>←</span></a></div>
            <div class="faq-accordion" data-faq-accordion>
                @forelse($questions as $index => $question)
                    <article class="faq-item {{ $index === 0 ? 'is-open' : '' }}">
                        <button class="faq-question" type="button" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"><span><small>{{ $question['tag'] }}</small>{{ $question['question'] }}</span><b>+</b></button>
                        <div class="faq-answer"><p>{{ $question['answer'] }}</p><small>پاسخ پزشک · {{ $question['date'] }}</small></div>
                    </article>
                @empty
                    <div class="empty-related">هنوز پاسخ تأییدشده‌ای منتشر نشده است.</div>
                @endforelse
            </div>
        </div>
        <aside class="faq-library-visual"><img src="{{ asset('images/photo_5976571529715716017_y.webp') }}" alt="تجربه آرام درمان در مطب"><div class="faq-visual-card"><span class="eyebrow">پاسخ مطمئن</span><strong>سلامت دهان، با آگاهی شروع می‌شود.</strong><a href="{{ route('questions') }}">پرسش خود را بپرسید <span>←</span></a></div></aside>
    </div>
</section>
<script>
(() => { const root = document.querySelector('[data-faq-accordion]'); if (!root || root.dataset.ready) return; root.dataset.ready = 'true'; root.querySelectorAll('.faq-question').forEach(button => button.addEventListener('click', () => { const item = button.closest('.faq-item'); const open = item.classList.contains('is-open'); root.querySelectorAll('.faq-item').forEach(other => { other.classList.remove('is-open'); other.querySelector('.faq-question').setAttribute('aria-expanded', 'false'); }); if (!open) { item.classList.add('is-open'); button.setAttribute('aria-expanded', 'true'); } })); })();
</script>


