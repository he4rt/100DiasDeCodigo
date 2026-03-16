@props ([
    'total_days' => 0,
])

<div
    class="w-full dark:border-gray-800"
    @if ($total_days >= 1)
        x-data="{ totalDays: @js($total_days) }"
    @else
        x-data="{ totalDays: participant.total_days }"
    @endif
>
    <div class="mb-1 flex items-end justify-between">
        <h3 class="font-semibold text-gray-900 dark:text-white">Progress</h3>
        <span class="text-sm font-medium text-gray-500 dark:text-gray-400" x-text="totalDays + '/100'"></span>
    </div>
    <div
        class="h-3 w-full overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800"
        role="progressbar"
        aria-valuenow="{{ $total_days }}"
        x-bind:aria-valuenow="totalDays"
        aria-valuemin="0"
        aria-valuemax="100"
    >
        <div
            x-cloak
            class="from-primary-500 mb-2 h-full rounded-full bg-linear-to-r to-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)] transition-all duration-1000 ease-out"
            x-bind:style="`width: ${Math.min((totalDays / 100) * 100, 100)}%`"
        ></div>
    </div>
</div>
