<?php

namespace App\Filament\Pages;

use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class Tools extends Page
{
    protected string $view = 'filament.pages.tools';
    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedWrenchScrewdriver;
    protected static ?string $navigationLabel = 'ابزارها';
    protected static ?string $title = 'ابزارهای سایت';

    public function storageLink(): void { Artisan::call('storage:link'); $this->ok('لینک Storage بررسی و ایجاد شد.'); }
    public function clearCache(): void { Artisan::call('optimize:clear'); $this->ok('کش‌های Laravel پاک شدند.'); }
    public function migrate(): void { Artisan::call('migrate', ['--force' => true]); $this->ok('Migration دیتابیس اجرا شد.'); }
    public function seed(): void { Artisan::call('db:seed', ['--force' => true]); $this->ok('Seeder دیتابیس اجرا شد.'); }
    public function getRecentLogsProperty(): string { $path = storage_path('logs/laravel.log'); if (!is_file($path)) return 'لاگی ثبت نشده است.'; return mb_substr(file_get_contents($path), -12000); }
    protected function ok(string $message): void { Notification::make()->title($message)->success()->send(); }
}
