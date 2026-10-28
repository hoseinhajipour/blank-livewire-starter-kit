<?php

use Illuminate\Support\Facades\Route;
use App\Support\SiteCatalog;
use App\Models\SiteSetting;
use Illuminate\Http\Response;

Route::get('/sitemap.xml', function (): Response {
    abort_unless(!SiteSetting::query()->exists() || SiteSetting::query()->value('sitemap_enabled'), 404);
    $urls = [
        ['loc' => route('home'), 'changefreq' => 'weekly', 'priority' => '1.0'],
        ['loc' => route('services'), 'changefreq' => 'monthly', 'priority' => '0.9'],
        ['loc' => route('articles'), 'changefreq' => 'weekly', 'priority' => '0.8'],
        ['loc' => route('questions'), 'changefreq' => 'weekly', 'priority' => '0.7'],
        ['loc' => route('about'), 'changefreq' => 'monthly', 'priority' => '0.6'],
        ['loc' => route('contact'), 'changefreq' => 'monthly', 'priority' => '0.7'],
    ];

    foreach (SiteCatalog::services() as $service) {
        $urls[] = ['loc' => route('service.show', $service['slug']), 'changefreq' => 'monthly', 'priority' => '0.8'];
    }

    foreach (SiteCatalog::articles() as $article) {
        $urls[] = ['loc' => route('article.show', $article['slug']), 'changefreq' => 'monthly', 'priority' => '0.7'];
    }

    $lastmod = now()->toAtomString();
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($urls as $url) {
        $xml .= '<url><loc>'.e($url['loc']).'</loc><lastmod>'.$lastmod.'</lastmod><changefreq>'.$url['changefreq'].'</changefreq><priority>'.$url['priority'].'</priority></url>';
    }
    $xml .= '</urlset>';

    return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
})->name('sitemap');

Route::get('/robots.txt', function (): Response {
    $body = "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /livewire\nSitemap: ".route('sitemap')."\n";

    return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
})->name('robots');

Route::get('/llms.txt', function (): Response {
    abort_unless(!SiteSetting::query()->exists() || SiteSetting::query()->value('llms_enabled'), 404);
    $body = "# مطب دندانپزشکی دکتر اشرف سادات حسینی\n\n"
        ."> مرجع رسمی معرفی خدمات، مقالات آموزشی و اطلاعات تماس مطب دندانپزشکی دکتر حسینی در لواسان.\n\n"
        ."## صفحات اصلی\n"
        ."- خانه: ".route('home')."\n"
        ."- خدمات: ".route('services')."\n"
        ."- مجله سلامت: ".route('articles')."\n"
        ."- پرسش و پاسخ: ".route('questions')."\n"
        ."- درباره پزشک: ".route('about')."\n"
        ."- تماس با ما: ".route('contact')."\n\n"
        ."## خدمات\n";
    foreach (SiteCatalog::services() as $service) {
        $body .= '- '.$service['title'].': '.route('service.show', $service['slug']).' — '.$service['desc']."\n";
    }
    $body .= "\n## مقالات آموزشی\n";
    foreach (SiteCatalog::articles() as $article) {
        $body .= '- '.$article['title'].': '.route('article.show', $article['slug'])."\n";
    }
    $body .= "\n## راهنمای استفاده\nمحتوای پزشکی این سایت برای آموزش عمومی است و جایگزین معاینه و تشخیص پزشک نیست. برای تصمیم درمانی با مطب تماس بگیرید.\n";

    return response($body, 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
})->name('llms');

Route::view('/', 'home')->name('home');
Route::view('/services', 'services')->name('services');
Route::get('/services/{service}', function (string $service) {
    abort_unless(collect(SiteCatalog::services())->contains('slug', $service), 404);
    return view('service', ['service' => $service]);
})->name('service.show');
Route::view('/articles', 'articles')->name('articles');
Route::get('/articles/{article}', function (string $article) {
    abort_unless(collect(SiteCatalog::articles())->contains('slug', $article), 404);
    return view('article', ['article' => $article]);
})->name('article.show');
Route::view('/questions', 'questions')->name('questions');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
