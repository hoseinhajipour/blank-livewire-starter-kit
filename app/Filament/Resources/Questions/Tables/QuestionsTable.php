<?php

namespace App\Filament\Resources\Questions\Tables;

use App\Support\SiteCatalog;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class QuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('subject')->label('موضوع')->searchable()->limit(45),
                TextColumn::make('service_slug')->label('خدمت')->formatStateUsing(fn (string $state): string => collect(SiteCatalog::services())->firstWhere('slug', $state)['title'] ?? $state),
                TextColumn::make('name')->label('کاربر')->searchable(),
                TextColumn::make('status')->label('وضعیت')->badge()->colors(['warning' => 'pending', 'success' => 'approved', 'danger' => 'rejected']),
                TextColumn::make('created_at')->label('تاریخ')->dateTime('Y/m/d H:i')->sortable(),
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
