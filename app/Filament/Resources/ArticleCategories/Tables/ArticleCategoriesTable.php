<?php

namespace App\Filament\Resources\ArticleCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class ArticleCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('دسته‌بندی')->searchable(),
                TextColumn::make('slug')->label('نامک')->searchable(),
                TextColumn::make('articles_count')->counts('articles')->label('تعداد مقاله'),
                TextColumn::make('is_active')->label('فعال')->badge()->formatStateUsing(fn (bool $state): string => $state ? 'فعال' : 'غیرفعال'),
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
