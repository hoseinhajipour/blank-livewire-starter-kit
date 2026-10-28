<x-filament-widgets::widget>
    <div class="flex flex-col gap-4 rounded-2xl bg-white p-6 text-gray-900 shadow-xl ring-1 ring-gray-200 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-[#bd8d41] text-2xl text-white">✦</div>
            <div>
                <p class="text-sm text-gray-500">خوش آمدید</p>
                <h2 class="text-xl font-bold">{{ auth()->user()->name ?? 'مدیر مطب' }}</h2>
                <p class="mt-1 text-sm text-gray-600">مدیریت محتوای سایت و ارتباط با مراجعه‌کنندگان</p>
            </div>
        </div>
        <div class="rounded-xl bg-[#f8f2e6] px-4 py-3 text-sm text-[#7a5a25]">پنل مدیریت مطب دکتر حسینی</div>
    </div>
</x-filament-widgets::widget>
