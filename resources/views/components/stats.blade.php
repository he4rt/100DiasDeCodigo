@props ([
    'icon',
    'label',
    'value',
    'suffix' => null,
    'color' => 'text-primary-500',
    'bgColor' => 'bg-primary-500/10',
])

<div
    class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white/50 p-3 backdrop-blur-sm lg:p-3.5 dark:border-gray-800 dark:bg-gray-900/50"
>
    <div @class (['flex-shrink-0 rounded-lg p-2', $bgColor])>
        <x-filament::icon :icon="$icon" @class (['h-4 w-4', $color]) />
    </div>
    <div class="min-w-0">
        <p class="truncate text-lg leading-tight font-bold text-gray-900 lg:text-xl dark:text-white">
            {{ $value }}
            @if ($suffix)
                <span class="ml-1 text-xs font-normal text-gray-500 dark:text-gray-400">{{ $suffix }}</span>
            @endif
        </p>
        <p class="truncate text-xs text-gray-500 dark:text-gray-400">{{ $label }}</p>
    </div>
</div>
