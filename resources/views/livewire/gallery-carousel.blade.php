<section class="section gallery-lightbox-section" wire:ignore>
    <div class="container">
        <div class="section-head"><div><span class="eyebrow">در مطب ما</span><h2>لبخندها، روایت اعتمادند</h2></div><span class="gallery-hint">برای مشاهده تصویر کلیک کنید</span></div>
        <div class="gallery-lightbox" data-gallery-lightbox>
            <div class="gallery-track" data-gallery-track>
                @foreach($images as $image)
                    @php($imageUrl = str_starts_with($image->image_path, 'gallery/') ? asset('storage/'.$image->image_path) : asset('images/'.$image->image_path))
                    <button class="gallery-slide" type="button" data-gallery-slide data-full="{{ $imageUrl }}" data-title="{{ $image->title }}" aria-label="نمایش {{ $image->title }}">
                        <img src="{{ $imageUrl }}" alt="{{ $image->alt ?: $image->title }}" loading="lazy">
                        <span class="gallery-slide-caption">{{ $image->title }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
    <div class="gallery-modal" data-gallery-modal hidden role="dialog" aria-modal="true" aria-label="نمایش بزرگ تصویر">
        <button class="gallery-modal-close" type="button" data-gallery-close aria-label="بستن">×</button>
        <figure><img data-gallery-modal-image src="" alt=""><figcaption data-gallery-modal-title></figcaption></figure>
    </div>
</section>
<script>
(() => {
    const root = document.querySelector('[data-gallery-lightbox]');
    if (!root || root.dataset.ready) return;
    root.dataset.ready = 'true';
    const modal = document.querySelector('[data-gallery-modal]');
    const modalImage = document.querySelector('[data-gallery-modal-image]');
    const modalTitle = document.querySelector('[data-gallery-modal-title]');
    root.querySelectorAll('[data-gallery-slide]').forEach(slide => slide.addEventListener('click', () => {
        modalImage.src = slide.dataset.full;
        modalImage.alt = slide.querySelector('img').alt;
        modalTitle.textContent = slide.dataset.title;
        modal.hidden = false;
        document.body.classList.add('gallery-modal-open');
    }));
    const close = () => { modal.hidden = true; document.body.classList.remove('gallery-modal-open'); };
    modal?.querySelector('[data-gallery-close]')?.addEventListener('click', close);
    modal?.addEventListener('click', event => { if (event.target === modal) close(); });
    document.addEventListener('keydown', event => { if (event.key === 'Escape' && modal && !modal.hidden) close(); });
})();
</script>


