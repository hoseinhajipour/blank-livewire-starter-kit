<?php

namespace App\Filament\Resources\Articles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ArticlesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')->label('تصویر')->disk('public'),
                TextColumn::make('title')->label('عنوان')->searchable()->limit(50),
                TextColumn::make('category.name')->label('دسته‌بندی')->searchable(),
                TextColumn::make('is_published')->label('وضعیت')->badge()->formatStateUsing(fn (bool $state): string => $state ? 'منتشر شده' : 'پیش‌نویس'),
                TextColumn::make('published_at')->label('انتشار')->dateTime('Y/m/d')->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
