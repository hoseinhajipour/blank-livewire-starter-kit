<?php

namespace App\Filament\Resources\SiteSettings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class SiteSettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('site_title')->label('عنوان سایت')->searchable(),
                TextColumn::make('sitemap_enabled')->label('Sitemap')->badge()->formatStateUsing(fn (bool $state): string => $state ? 'فعال' : 'غیرفعال'),
                TextColumn::make('llms_enabled')->label('LLM TXT')->badge()->formatStateUsing(fn (bool $state): string => $state ? 'فعال' : 'غیرفعال'),
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
