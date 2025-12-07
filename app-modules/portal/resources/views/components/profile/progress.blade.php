@props([
    'stats',
])

<div class="space-y-3 border-t border-gray-200 pt-6 dark:border-gray-800">
    <div class="flex items-end justify-between">
        <h3 class="font-semibold text-gray-900 dark:text-white">Challenge Progress</h3>
        <span
            class="text-sm font-medium text-gray-500 dark:text-gray-400"
            aria-label="{{ $stats['total_days'] }} out of 100 days completed"
        >
            {{ $stats['total_days'] }}/100 days
        </span>
    </div>
    <div
        class="h-3 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800"
        role="progressbar"
        aria-valuenow="{{ $stats['total_days'] }}"
        aria-valuemin="0"
        aria-valuemax="100"
    >
        <div
            class="from-primary-500 h-full rounded-full bg-gradient-to-r to-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)] transition-all duration-1000 ease-out"
            style="width: {{ min(($stats['total_days'] / 100) * 100, 100) }}%"
        ></div>
    </div>
</div>
