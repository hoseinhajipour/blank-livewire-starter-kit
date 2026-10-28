<?php

namespace App\Filament\Resources\GalleryImages\Schemas;

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
                TextInput::make('image_path')->label('مسیر فایل')->required()->helperText('مسیر نسبت به public/images، مانند photo_...webp'),
                TextInput::make('alt')->label('متن جایگزین')->required(),
                TextInput::make('sort_order')->label('ترتیب نمایش')->numeric()->default(0),
                Toggle::make('is_active')->label('نمایش در سایت')->default(true),
            ]);
    }
}
