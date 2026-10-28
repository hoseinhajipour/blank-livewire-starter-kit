<section class="section gallery-lightbox-section" wire:ignore>
 <div class="container">
  <div class="section-head"><div><span class="eyebrow">در مطب ما</span><h2>لبخندها، روایت اعتمادند</h2></div><span class="gallery-hint">برای مشاهده تصویر کلیک کنید</span></div>
  @php
   $items = $images->map(fn ($image) => ['src' => str_starts_with($image->image_path, 'gallery/') ? asset('storage/'.$image->image_path) : asset('images/'.$image->image_path), 'title' => $image->title, 'alt' => $image->alt ?: $image->title])->values();
  @endphp
  <div data-vue-gallery data-items="{{ $items->toJson() }}"></div>
 </div>
</section>
