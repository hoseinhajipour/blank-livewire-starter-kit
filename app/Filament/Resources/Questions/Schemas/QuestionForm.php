<?php

namespace App\Filament\Resources\Questions\Schemas;

use App\Support\SiteCatalog;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('service_slug')->label('خدمت مرتبط')->options(collect(SiteCatalog::services())->pluck('title', 'slug'))->required(),
                TextInput::make('name')->label('نام کاربر')->required(),
                TextInput::make('email')->label('ایمیل')->email(),
                TextInput::make('subject')->label('موضوع سوال')->required()->maxLength(180),
                Textarea::make('body')->label('متن سوال')->required()->rows(5),
                Select::make('status')->label('وضعیت')->options(['pending' => 'در انتظار بررسی', 'approved' => 'تأیید و منتشر شود', 'rejected' => 'رد شده'])->required()->default('pending'),
                Textarea::make('answer')->label('پاسخ پزشک')->rows(6)->helperText('برای انتشار سوال، وضعیت را روی تأیید و منتشر شود بگذارید و پاسخ را وارد کنید.'),
            ]);
    }
}
