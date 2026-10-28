<?php

namespace App\Filament\Resources\ArticleCategories\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ArticleCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('نام دسته‌بندی')->required(),
                TextInput::make('slug')->label('نامک')->required()->unique(ignoreRecord: true),
                Textarea::make('description')->label('توضیحات')->rows(3),
                Toggle::make('is_active')->label('فعال')->default(true),
            ]);
    }
}
