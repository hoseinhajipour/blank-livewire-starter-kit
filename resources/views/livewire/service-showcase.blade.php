<section class="section section-services service-showcase">
    <div class="container">
        <div class="section-head service-showcase-head"><div><span class="eyebrow">خدمات تخصصی</span><h2>مراقبت کامل از لبخند شما</h2><p>راهکارهای دقیق و شخصی‌سازی‌شده برای سلامت، زیبایی و آرامش بیشتر.</p></div></div>
        <div class="service-grid service-grid-home">
            @foreach($services as $service)
                <a class="service-card service-card-layered" href="{{ route('service.show',$service['slug']) }}">
                    <div class="service-card-image"><img src="{{ asset($service['image']) }}" alt="{{ $service['title'] }}"><span class="service-card-number">۰{{ $loop->iteration }}</span></div>
                    <div class="service-card-content"><h3>{{ $service['title'] }}</h3><p>{{ $service['desc'] }}</p><span class="card-arrow">مشاهده خدمت <b>←</b></span></div>
                </a>
            @endforeach
        </div>
        <div class="services-showcase-action"><a class="btn btn-gold services-all-button" href="{{ route('services') }}">مشاهده همه خدمات <span>←</span></a></div>
    </div>
</section>

