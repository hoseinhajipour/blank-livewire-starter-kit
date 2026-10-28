<?php

namespace App\Support;

use App\Models\Article;
use App\Models\Service;
use Illuminate\Support\Facades\Schema;

final class SiteCatalog
{
    public static function services(): array
    {
        if (Schema::hasTable('services') && Service::query()->exists()) {
            return Service::visible()->get()->map(fn (Service $service): array => [
                'slug' => $service->slug, 'image' => $service->image ? (str_contains($service->image, '/') ? 'storage/'.$service->image : 'images/services/'.$service->image) : 'images/icon.webp', 'title' => $service->title,
                'desc' => $service->desc, 'content' => $service->content, 'sort_order' => $service->sort_order,
            ])->all();
        }
        return [
            ['slug'=>'root-canal','image'=>'images/services/root-canal.webp','title'=>'درمان ریشه','desc'=>'نجات دندان‌های آسیب‌دیده با درمان دقیق و کم‌درد.'],
            ['slug'=>'cosmetic','image'=>'images/services/cosmetic.webp','title'=>'دندانپزشکی زیبایی','desc'=>'سفیدکردن، لمینت و اصلاح خط لبخند با طراحی شخصی.'],
            ['slug'=>'pediatric','image'=>'images/services/pediatric.webp','title'=>'دندانپزشکی کودکان','desc'=>'محیطی آرام برای ساختن تجربه‌ای شیرین از دندانپزشکی.'],
            ['slug'=>'prosthesis','image'=>'images/services/prosthesis.webp','title'=>'پروتز و بازسازی','desc'=>'بازگرداندن عملکرد و زیبایی دندان‌ها با راهکارهای ماندگار.'],
        ];
    }

    public static function articles(): array
    {
        if (Schema::hasTable('articles') && Article::published()->exists()) {
            return Article::published()->with('category')->orderBy('sort_order')->latest('published_at')->get()->map(fn (Article $article): array => [
                'slug' => $article->slug, 'category' => $article->category?->name ?? 'سلامت دهان',
                'title' => $article->title, 'date' => optional($article->published_at)->format('d M Y') ?? 'جدید',
                'image' => $article->featured_image ? (str_starts_with($article->featured_image, 'articles/') ? 'storage/'.$article->featured_image : 'images/articles/'.$article->featured_image) : 'images/icon.webp', 'excerpt' => $article->excerpt,
                'content' => $article->content, 'services' => self::articleServices($article->slug),
            ])->all();
        }
        return [
            ['slug'=>'prevention','category'=>'پیشگیری','title'=>'چطور از پوسیدگی دندان پیشگیری کنیم؟','date'=>'۲۴ مهر ۱۴۰۵','image'=>'images/articles/prevention.webp','services'=>['root-canal','pediatric','prosthesis']],
            ['slug'=>'children','category'=>'کودکان','title'=>'اولین مراجعه کودک به دندانپزشک؛ راهنمای والدین','date'=>'۱۷ مهر ۱۴۰۵','image'=>'images/articles/children.webp','services'=>['pediatric']],
            ['slug'=>'smile','category'=>'زیبایی','title'=>'لبخند طبیعی؛ از سفیدکردن تا اصلاح فرم دندان','date'=>'۰۸ مهر ۱۴۰۵','image'=>'images/articles/smile.webp','services'=>['cosmetic','prosthesis']],
        ];
    }

    private static function articleServices(string $slug): array
    {
        return match ($slug) {
            'prevention' => ['root-canal', 'pediatric', 'prosthesis'],
            'children' => ['pediatric'],
            'smile' => ['cosmetic', 'prosthesis'],
            default => [],
        };
    }

    public static function questions(): array
    {
        return [
            ['service'=>'root-canal','tag'=>'درمان ریشه','question'=>'آیا درمان ریشه دردناک است؟','answer'=>'با بی‌حسی دقیق و برنامه‌ریزی مناسب، بیشتر بیماران درمان ریشه را با ناراحتی قابل کنترل تجربه می‌کنند. حساسیت کوتاه‌مدت بعد از درمان نیز معمولاً با مراقبت ساده مدیریت می‌شود.','date'=>'۳ روز پیش'],
            ['service'=>'root-canal','tag'=>'درمان ریشه','question'=>'بعد از عصب‌کشی چه مراقبت‌هایی لازم است؟','answer'=>'تا برطرف شدن بی‌حسی از جویدن پرهیز کنید، بهداشت دهان را ادامه دهید و برای ترمیم نهایی دندان طبق زمان‌بندی پزشک مراجعه کنید.','date'=>'۱ هفته پیش'],
            ['service'=>'root-canal','tag'=>'درمان ریشه','question'=>'چه زمانی به درمان ریشه نیاز داریم؟','answer'=>'درد مداوم، حساسیت طولانی به گرما و سرما، تغییر رنگ دندان یا تورم لثه می‌تواند نشانه درگیری پالپ باشد و نیاز به معاینه دقیق دارد.','date'=>'۲ هفته پیش'],
            ['service'=>'root-canal','tag'=>'درمان ریشه','question'=>'آیا دندان عصب‌کشی‌شده دوباره پوسیده می‌شود؟','answer'=>'بله، درمان ریشه عصب را خارج می‌کند اما از پوسیدگی جلوگیری نمی‌کند. ترمیم مناسب، مسواک و معاینه دوره‌ای برای حفظ دندان ضروری است.','date'=>'۳ هفته پیش'],
            ['service'=>'cosmetic','tag'=>'زیبایی','question'=>'سفیدکردن دندان برای همه مناسب است؟','answer'=>'پیش از سفیدکردن باید پوسیدگی، التهاب لثه و حساسیت بررسی شود. پس از معاینه، روش و غلظت مناسب برای شرایط شما انتخاب می‌شود.','date'=>'۴ روز پیش'],
            ['service'=>'cosmetic','tag'=>'زیبایی','question'=>'تفاوت لمینت و سفیدکردن دندان چیست؟','answer'=>'سفیدکردن بیشتر روی رنگ دندان اثر می‌گذارد، اما لمینت می‌تواند رنگ، فرم و برخی ناهماهنگی‌های ظاهری را هم اصلاح کند.','date'=>'۱۰ روز پیش'],
            ['service'=>'cosmetic','tag'=>'زیبایی','question'=>'نتیجه سفیدکردن دندان چقدر ماندگار است؟','answer'=>'ماندگاری به عادت‌های غذایی، مصرف دخانیات و بهداشت دهان بستگی دارد. رعایت مراقبت‌های پس از درمان به حفظ رنگ روشن کمک می‌کند.','date'=>'۲ هفته پیش'],
            ['service'=>'cosmetic','tag'=>'زیبایی','question'=>'آیا قبل از درمان زیبایی باید دندان‌ها سالم باشند؟','answer'=>'بله، ابتدا پوسیدگی و بیماری لثه باید درمان شود تا نتیجه زیبایی هم سالم، ایمن و ماندگار باشد.','date'=>'۳ هفته پیش'],
            ['service'=>'pediatric','tag'=>'دندانپزشکی کودکان','question'=>'اولین مراجعه کودک به دندانپزشک چه زمانی باشد؟','answer'=>'بهتر است اولین ویزیت با رویش اولین دندان یا حداکثر تا یک‌سالگی انجام شود تا پیشگیری و عادت‌های درست از ابتدا شکل بگیرد.','date'=>'۲ روز پیش'],
            ['service'=>'pediatric','tag'=>'دندانپزشکی کودکان','question'=>'چطور ترس کودک از دندانپزشکی را کمتر کنیم؟','answer'=>'از واژه‌های ترسناک استفاده نکنید، تجربه را کوتاه و مثبت نگه دارید و اجازه دهید کودک با محیط و ابزارها به‌تدریج آشنا شود.','date'=>'۶ روز پیش'],
            ['service'=>'pediatric','tag'=>'دندانپزشکی کودکان','question'=>'آیا دندان شیری خراب باید حتماً درمان شود؟','answer'=>'بله، دندان شیری برای جویدن، صحبت کردن و حفظ فضای دندان دائمی مهم است و بی‌توجهی به آن می‌تواند درد و عفونت ایجاد کند.','date'=>'۲ هفته پیش'],
            ['service'=>'pediatric','tag'=>'دندانپزشکی کودکان','question'=>'چند بار در روز باید دندان کودک را مسواک زد؟','answer'=>'دو بار در روز با خمیردندان فلورایددار مناسب سن و مقدار کم، زیر نظر والدین، بهترین الگوی مراقبت روزانه است.','date'=>'۳ هفته پیش'],
            ['service'=>'prosthesis','tag'=>'پروتز و بازسازی','question'=>'پروتز دندان چقدر دوام دارد؟','answer'=>'دوام پروتز به نوع آن، وضعیت لثه و استخوان، رعایت بهداشت و مراجعات دوره‌ای بستگی دارد و با مراقبت درست می‌تواند سال‌ها عملکرد مناسبی داشته باشد.','date'=>'۵ روز پیش'],
            ['service'=>'prosthesis','tag'=>'پروتز و بازسازی','question'=>'آیا پروتز در روزهای اول ناراحت‌کننده است؟','answer'=>'احساس متفاوت بودن یا فشار خفیف در روزهای اول طبیعی است. تنظیم‌های اولیه و پیگیری پزشک به سازگاری بهتر کمک می‌کند.','date'=>'۲ هفته پیش'],
            ['service'=>'prosthesis','tag'=>'پروتز و بازسازی','question'=>'چطور از پروتز دندان مراقبت کنیم؟','answer'=>'پروتز را طبق دستور تمیز کنید، هنگام خواب در صورت توصیه پزشک خارج کنید و برای بررسی لثه و تنظیم، مراجعات دوره‌ای داشته باشید.','date'=>'۳ هفته پیش'],
            ['service'=>'prosthesis','tag'=>'پروتز و بازسازی','question'=>'آیا با پروتز می‌توان غذاهای معمولی خورد؟','answer'=>'پس از دوره سازگاری، بیشتر غذاها قابل استفاده‌اند؛ بهتر است ابتدا با غذاهای نرم شروع کنید و از گاز زدن مستقیم مواد بسیار سفت پرهیز کنید.','date'=>'۱ ماه پیش'],
        ];
    }
}

