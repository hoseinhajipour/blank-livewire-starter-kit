<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use App\Models\Question;
use App\Models\Service;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SiteStatsOverview extends StatsOverviewWidget
{
    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $pendingQuestions = Question::query()->where(function ($query): void {
            $query->where('status', '!=', 'approved')->orWhereNull('answer');
        })->count();

        return [
            Stat::make('مقالات منتشرشده', Article::published()->count())
                ->description('محتوای قابل مشاهده در مجله')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info')
                ->icon('heroicon-o-document-text'),
            Stat::make('خدمات فعال', Service::visible()->count())
                ->description('خدمات نمایش داده‌شده در سایت')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('warning')
                ->icon('heroicon-o-heart'),
            Stat::make('کل پرسش‌ها', Question::query()->count())
                ->description('پرسش‌های ثبت‌شده کاربران')
                ->descriptionIcon('heroicon-m-chat-bubble-left-right')
                ->color('success')
                ->icon('heroicon-o-chat-bubble-left-right'),
            Stat::make('در انتظار بررسی', $pendingQuestions)
                ->description('نیازمند پاسخ یا تأیید پزشک')
                ->descriptionIcon('heroicon-m-clock')
                ->color('danger')
                ->icon('heroicon-o-clock'),
        ];
    }
}
