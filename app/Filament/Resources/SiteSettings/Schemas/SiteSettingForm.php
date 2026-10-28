<?php

namespace App\Filament\Resources\SiteSettings\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SiteSettingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('site_title')->label('عنوان سایت')->required(),
                Textarea::make('site_description')->label('توضیحات سایت')->rows(3),
                Textarea::make('meta_description')->label('توضیحات متا')->rows(3),
                FileUpload::make('favicon_path')->label('فاوآیکون')->image()->disk('public')->directory('settings'),
                FileUpload::make('site_icon_path')->label('آیکون اصلی سایت')->image()->disk('public')->directory('settings'),
                FileUpload::make('og_image_path')->label('تصویر Open Graph')->image()->disk('public')->directory('settings'),
                Toggle::make('sitemap_enabled')->label('فعال بودن Sitemap')->default(true),
                Toggle::make('llms_enabled')->label('فعال بودن llms.txt')->default(true),
                Toggle::make('responsive_mode')->label('حالت ریسپانسیو')->default(true),
            ]);
    }
}
