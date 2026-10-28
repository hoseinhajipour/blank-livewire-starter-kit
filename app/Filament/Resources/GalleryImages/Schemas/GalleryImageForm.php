<?php

namespace App\Filament\Resources\GalleryImages\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GalleryImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->label('عنوان تصویر')->required(),
                FileUpload::make('image_path')->label('تصویر گالری')->image()->disk('public')->directory('gallery')->visibility('public')->imagePreviewHeight('240')->openable()->downloadable()->acceptedFileTypes(['image/jpeg', 'image/png', 'image/webp'])->maxSize(5120)->required()->helperText('تصویر را انتخاب کنید؛ پیش‌نمایش قبل از ذخیره نمایش داده می‌شود.'),
                TextInput::make('alt')->label('متن جایگزین')->required(),
                TextInput::make('sort_order')->label('ترتیب نمایش')->numeric()->default(0),
                Toggle::make('is_active')->label('نمایش در سایت')->default(true),
            ]);
    }
}
