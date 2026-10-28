<div>
@if($sent)
  <div class="success-message"><strong>پرسش شما ثبت شد.</strong><br>سوال شما پس از بررسی و تأیید پزشک در بخش پرسش‌وپاسخ منتشر خواهد شد.</div>
@else
  <form class="contact-form question-form" wire:submit="submit">
    <div class="form-two">
      <div><input wire:model="name" placeholder="نام شما *" autocomplete="name">@error('name')<small class="error">{{ $message }}</small>@enderror</div>
      <div><input wire:model="email" type="email" placeholder="ایمیل (اختیاری)" autocomplete="email">@error('email')<small class="error">{{ $message }}</small>@enderror</div>
    </div>
    <select wire:model="service_slug" aria-label="انتخاب خدمت">
      <option value="">خدمت مرتبط را انتخاب کنید *</option>
      @foreach($services as $service)<option value="{{ $service['slug'] }}">{{ $service['title'] }}</option>@endforeach
    </select>
    @error('service_slug')<small class="error">{{ $message }}</small>@enderror
    <input wire:model="subject" placeholder="موضوع پرسش *">@error('subject')<small class="error">{{ $message }}</small>@enderror
    <textarea wire:model="body" rows="6" placeholder="پرسش خود را با جزئیات بنویسید *"></textarea>@error('body')<small class="error">{{ $message }}</small>@enderror
    <button class="btn btn-dark" type="submit" wire:loading.attr="disabled"><span wire:loading.remove>ارسال برای بررسی پزشک ←</span><span wire:loading>در حال ارسال...</span></button>
  </form>
@endif
</div>


