<?php

namespace App\Filament\Resources\GalleryImages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class GalleryImagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')->label('تصویر')->disk('public')->url(fn ($record): string => str_starts_with($record->image_path, 'gallery/') ? asset('storage/'.$record->image_path) : asset('images/'.$record->image_path)),
                TextColumn::make('title')->label('عنوان')->searchable(),
                TextColumn::make('image_path')->label('فایل'),
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
