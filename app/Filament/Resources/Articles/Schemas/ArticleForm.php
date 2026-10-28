<?php

namespace App\Filament\Resources\Articles\Schemas;

use App\Models\ArticleCategory;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ArticleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->label('عنوان مقاله')->required()->maxLength(180),
                TextInput::make('slug')->label('نامک')->required()->unique(ignoreRecord: true),
                Select::make('category_id')->label('دسته‌بندی')->options(fn () => ArticleCategory::where('is_active', true)->pluck('name', 'id'))->searchable()->required(),
                Textarea::make('excerpt')->label('خلاصه و توضیحات متا')->rows(3)->columnSpanFull(),
                RichEditor::make('content')->label('محتوای مقاله')->toolbarButtons(['bold','italic','h2','h3','bulletList','orderedList','blockquote','link','undo','redo'])->columnSpanFull()->required(),
                FileUpload::make('featured_image')->label('تصویر شاخص')->image()->disk('public')->directory('articles')->imagePreviewHeight('220')->openable()->downloadable(),
                DateTimePicker::make('published_at')->label('تاریخ انتشار')->seconds(false),
                TextInput::make('sort_order')->label('اولویت نمایش')->numeric()->default(0),
                Toggle::make('is_published')->label('منتشر شده')->default(false),
            ]);
    }
}
