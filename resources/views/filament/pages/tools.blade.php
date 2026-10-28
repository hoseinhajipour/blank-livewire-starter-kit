<x-filament-panels::page>
    <div class="grid gap-6 lg:grid-cols-2">
        <x-filament::section heading="عملیات سیستم" description="ابزارهای نگهداری پروژه را فقط در زمان نیاز اجرا کنید.">
            <div class="grid gap-3 sm:grid-cols-2">
                <x-filament::button wire:click="storageLink">ایجاد Storage Link</x-filament::button>
                <x-filament::button color="gray" wire:click="clearCache" wire:confirm="کش‌های Laravel پاک شود؟">پاک کردن کش</x-filament::button>
                <x-filament::button color="warning" wire:click="migrate" wire:confirm="Migration دیتابیس اجرا شود؟">Migration دیتابیس</x-filament::button>
                <x-filament::button color="warning" wire:click="seed" wire:confirm="Seeder دیتابیس اجرا شود؟">Seed دیتابیس</x-filament::button>
            </div>
        </x-filament::section>
        <x-filament::section heading="آخرین لاگ‌های Laravel">
            <pre class="max-h-96 overflow-auto rounded-lg bg-gray-950 p-4 text-xs leading-6 text-gray-200" dir="ltr">{{ $this->recentLogs }}</pre>
        </x-filament::section>
    </div>
</x-filament-panels::page>
