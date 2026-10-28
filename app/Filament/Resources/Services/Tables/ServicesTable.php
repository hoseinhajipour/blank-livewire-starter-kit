<?php

namespace App\Filament\Resources\Services\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;

class ServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->label('تصویر')->disk('public'),
                TextColumn::make('title')->label('عنوان')->searchable(),
                TextColumn::make('slug')->label('نامک')->searchable(),
                TextColumn::make('sort_order')->label('اولویت')->sortable(),
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
