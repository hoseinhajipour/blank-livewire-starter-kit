<?php

namespace App\Providers;

use App\Support\ArticleContent;
use App\Support\SiteCatalog;
use App\Models\Question;
use App\Models\SiteSetting;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        View::composer(['home', 'services', 'service', 'articles', 'article'], function ($view): void {
            $services = SiteCatalog::services();
            $articles = SiteCatalog::articles();
            $questions = Question::approved()->latest('approved_at')->get()->map(fn (Question $question): array => [
                'service' => $question->service_slug,
                'tag' => collect($services)->firstWhere('slug', $question->service_slug)['title'] ?? 'دندانپزشکی',
                'question' => $question->subject,
                'answer' => $question->answer,
                'date' => optional($question->approved_at)->diffForHumans() ?? 'تازه',
            ])->all();
            $view->with(compact('services', 'articles', 'questions'))->with('gallery', array_column($articles, 'image'))->with('articleContent', ArticleContent::all());
        });

        View::composer('questions', function ($view): void {
            $services = SiteCatalog::services();
            $publishedQuestions = Question::approved()->latest('approved_at')->get()->map(function (Question $question) use ($services): array {
                $service = collect($services)->firstWhere('slug', $question->service_slug);

                return [
                    'tag' => $service['title'] ?? 'دندانپزشکی',
                    'question' => $question->subject,
                    'answer' => $question->answer,
                    'date' => optional($question->approved_at)->diffForHumans() ?? 'تازه',
                ];
            });
            $view->with(compact('services', 'publishedQuestions'));
        });

        View::composer('layouts.app', function ($view): void {
            $siteSettings = Schema::hasTable('site_settings') ? SiteSetting::query()->first() : null;
            $routeName = request()->route()?->getName();
            $services = SiteCatalog::services();
            $articles = SiteCatalog::articles();
            $service = request()->route('service');
            $article = request()->route('article');
            $serviceItem = collect($services)->firstWhere('slug', $service);
            $articleItem = collect($articles)->firstWhere('slug', $article);

            $seo = match ($routeName) {
                'service.show' => [
                    'title' => ($serviceItem['title'] ?? 'خدمات دندانپزشکی').' | مطب دکتر حسینی',
                    'description' => ($serviceItem['desc'] ?? 'خدمات تخصصی دندانپزشکی با رویکردی دقیق و آرام در مطب دکتر حسینی.'),
                    'image' => $serviceItem ? asset($serviceItem['image']) : asset('images/icon.webp'),
                    'type' => 'MedicalWebPage',
                ],
                'article.show' => [
                    'title' => ($articleItem['title'] ?? 'مقالات سلامت دهان').' | مجله سلامت دکتر حسینی',
                    'description' => $articleItem ? 'راهنمای کاربردی و عامه‌پسند درباره '.$articleItem['title'].'؛ همراه با نکات مراقبتی و سوالات متداول.' : 'مقالات آموزشی سلامت دهان و دندان به زبان ساده.',
                    'image' => $articleItem ? asset($articleItem['image']) : asset('images/icon.webp'),
                    'type' => 'Article',
                ],
                'services' => ['title' => 'خدمات دندانپزشکی | مطب دکتر حسینی', 'description' => 'خدمات درمان ریشه، دندانپزشکی زیبایی، دندانپزشکی کودکان و پروتز و بازسازی در مطب دکتر حسینی.', 'image' => asset('images/icon.webp'), 'type' => 'CollectionPage'],
                'articles' => ['title' => 'مجله سلامت دهان و دندان | دکتر حسینی', 'description' => 'مقالات سئو‌شده و قابل فهم درباره پیشگیری، دندانپزشکی کودکان، زیبایی و مراقبت از دهان و دندان.', 'image' => asset('images/icon.webp'), 'type' => 'CollectionPage'],
                'questions' => ['title' => 'پرسش و پاسخ دندانپزشکی | دکتر حسینی', 'description' => 'پاسخ‌های کاربردی به سوالات رایج درباره سلامت دهان، خدمات دندانپزشکی و مراقبت‌های بعد از درمان.', 'image' => asset('images/icon.webp'), 'type' => 'FAQPage'],
                'about' => ['title' => 'درباره پزشک | دکتر اشرف سادات حسینی', 'description' => 'آشنایی با دکتر اشرف سادات حسینی، رویکرد درمانی، تجربه و خدمات مطب دندانپزشکی.', 'image' => asset('images/photo_5976571529715716028_y.webp'), 'type' => 'AboutPage'],
                'contact' => ['title' => 'تماس با مطب دکتر حسینی | لواسان', 'description' => 'آدرس، شماره تماس و راه‌های رزرو نوبت مطب دندانپزشکی دکتر اشرف سادات حسینی.', 'image' => asset('images/icon.webp'), 'type' => 'ContactPage'],
                default => ['title' => ($siteSettings?->site_title ?: 'مطب دندانپزشکی دکتر حسینی').' | درمان، زیبایی و کودکان', 'description' => ($siteSettings?->meta_description ?: 'مطب دندانپزشکی دکتر اشرف سادات حسینی؛ خدمات درمان ریشه، زیبایی، کودکان و بازسازی با رویکردی آرام و دقیق.'), 'image' => asset('images/icon.webp'), 'type' => 'WebSite'],
            };

            $structuredData = [
                '@context' => 'https://schema.org',
                '@type' => $seo['type'],
                'name' => $seo['title'],
                'url' => url()->current(),
                'description' => $seo['description'],
                'inLanguage' => 'fa-IR',
                'isPartOf' => ['@type' => 'WebSite', 'name' => 'مطب دندانپزشکی دکتر حسینی', 'url' => url('/')],
            ];
            if ($routeName === 'article.show' && $articleItem) {
                $structuredData['headline'] = $articleItem['title'];
                $structuredData['image'] = [$seo['image']];
                $structuredData['datePublished'] = '2026-10-16';
                $structuredData['author'] = ['@type' => 'Person', 'name' => 'دکتر اشرف سادات حسینی'];
                $structuredData['publisher'] = ['@type' => 'Organization', 'name' => 'مطب دکتر حسینی', 'logo' => ['@type' => 'ImageObject', 'url' => asset('images/logo-wide.webp')]];
            }
            if ($routeName === 'service.show' && $serviceItem) {
                $structuredData['serviceType'] = $serviceItem['title'];
                $structuredData['provider'] = ['@type' => 'Dentist', 'name' => 'دکتر اشرف سادات حسینی'];
            }

            $faqSchema = [];
            if ($routeName === 'article.show' && $articleItem) {
                $content = ArticleContent::all()[$articleItem['slug']] ?? null;
                if ($content) {
                    $faqSchema = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(fn (array $faq): array => [
                        '@type' => 'Question',
                        'name' => $faq['q'],
                        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $faq['a']],
                    ], $content['faq'])];
                }
            }

            $siteSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'Dentist',
                'name' => 'مطب دندانپزشکی دکتر اشرف سادات حسینی',
                'url' => url('/'),
                'telephone' => '+982654747265',
                'image' => asset('images/icon.webp'),
                'address' => ['@type' => 'PostalAddress', 'addressLocality' => 'لواسان', 'addressCountry' => 'IR'],
                'areaServed' => 'لواسان و اطراف',
            ];

            $view->with('seo', $seo)->with('structuredData', $structuredData)->with('faqSchema', $faqSchema)->with('siteSchema', $siteSchema)->with('siteSettings', $siteSettings);
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Schema::defaultStringLength(191);
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}

