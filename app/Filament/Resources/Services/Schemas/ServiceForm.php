<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->label('عنوان خدمت')->required()->maxLength(150),
                TextInput::make('slug')->label('نامک')->required()->unique(ignoreRecord: true),
                Textarea::make('desc')->label('توضیح کوتاه')->rows(3)->required(),
                RichEditor::make('content')->label('محتوای کامل خدمت')->toolbarButtons(['bold','italic','h2','h3','bulletList','orderedList','blockquote','link','undo','redo'])->columnSpanFull(),
                FileUpload::make('image')->label('تصویر شاخص خدمت')->image()->disk('public')->directory('services')->imagePreviewHeight('220')->openable()->downloadable(),
                TextInput::make('sort_order')->label('اولویت نمایش')->numeric()->default(0),
                Toggle::make('is_active')->label('نمایش در سایت')->default(true),
            ]);
    }
}
