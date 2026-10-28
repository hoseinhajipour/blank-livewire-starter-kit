<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\GalleryImage;
use App\Models\Article;
use App\Models\ArticleCategory;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Support\ArticleContent;
use App\Support\SiteCatalog;
use App\Support\ServiceContent;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@drhosseiniclinic.com')],
            [
                'name' => 'مدیر مطب دکتر حسینی',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'DrH@2026!Clinic#Admin')),
                'email_verified_at' => now(),
            ],
        );

        foreach (SiteCatalog::services() as $index => $service) {
            $record = Service::firstOrNew(['slug' => $service['slug']]);
            $record->fill(['title' => $service['title'], 'desc' => $service['desc'], 'image' => basename($service['image']), 'is_active' => true, 'sort_order' => $index + 1]);
            if (! $record->exists || blank($record->content) || mb_strlen(strip_tags($record->content)) < 300) {
                $record->content = ServiceContent::get($service['slug']);
            }
            $record->save();
        }

        $articleContents = ArticleContent::all();
        foreach (SiteCatalog::articles() as $index => $article) {
            $category = ArticleCategory::firstOrCreate(['slug' => $article['category']], ['name' => $article['category'], 'is_active' => true]);
            $content = $articleContents[$article['slug']] ?? null;
            $html = $content ? '<p>'.$content['intro'].'</p>'.collect($content['sections'])->map(fn (array $section): string => '<h2>'.$section['title'].'</h2>'.collect($section['paragraphs'])->map(fn (string $paragraph): string => '<p>'.$paragraph.'</p>')->implode(''))->implode('') : '<p>'.$article['title'].'</p>';
            Article::updateOrCreate(['slug' => $article['slug']], [
                'category_id' => $category->id, 'title' => $article['title'], 'excerpt' => $content['intro'] ?? $article['title'],
                'content' => $html, 'featured_image' => basename($article['image']), 'published_at' => now()->subDays($index + 1), 'is_published' => true, 'sort_order' => $index + 1,
            ]);
        }

        SiteSetting::firstOrCreate([], [
            'site_title' => 'مطب دندانپزشکی دکتر حسینی', 'site_description' => 'خدمات تخصصی دندانپزشکی در لواسان با رویکردی دقیق و آرام.', 'meta_description' => 'مطب دندانپزشکی دکتر اشرف سادات حسینی؛ درمان ریشه، زیبایی، کودکان و بازسازی دندان.', 'favicon_path' => 'icon.webp', 'site_icon_path' => 'icon.webp', 'og_image_path' => 'logo-wide.webp', 'sitemap_enabled' => true, 'llms_enabled' => true, 'responsive_mode' => true,
        ]);

        foreach (SiteCatalog::questions() as $question) {
            Question::firstOrCreate(
                ['service_slug' => $question['service'], 'subject' => $question['question']],
                [
                    'name' => 'پرسش رایج بیماران',
                    'body' => $question['question'],
                    'answer' => $question['answer'],
                    'status' => 'approved',
                    'approved_at' => now(),
                ],
            );
        }

        foreach ([
            ['path' => 'photo_5976571529715716019_y.webp', 'title' => 'محیط دوستانه مطب', 'alt' => 'محیط دوستانه مطب دندانپزشکی', 'sort' => 1],
            ['path' => 'photo_5976571529715716016_y.webp', 'title' => 'مراقبت از کودکان', 'alt' => 'مراقبت دندانپزشکی از کودک', 'sort' => 2],
            ['path' => 'photo_5976571529715716017_y.webp', 'title' => 'تجربه آرام درمان', 'alt' => 'تجربه آرام درمان دندانپزشکی', 'sort' => 3],
        ] as $image) {
            GalleryImage::firstOrCreate(
                ['image_path' => $image['path']],
                ['title' => $image['title'], 'alt' => $image['alt'], 'sort_order' => $image['sort'], 'is_active' => true],
            );
        }
    }
}

