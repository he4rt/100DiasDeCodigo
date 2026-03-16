@props ([
    'status' => 'pending',
    'day' => 1,
    'date' => null,
    'submission' => null,
])

@php
    $colors = [
        'pending' => 'border-gray-200 bg-gray-100 text-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-500',
        'complete' => 'bg-primary-500 border-primary-600 text-white shadow-[0_0_10px_rgba(99,102,241,0.4)]',
        'missed' => 'border-red-200 bg-red-100 text-red-400 dark:border-red-800 dark:bg-red-900/20 dark:text-red-500',
    ];

    $colorClass = $colors[$status] ?? $colors['pending'];

    $tooltip = "Day $day";
    if ($date) {
        $tooltip .= ' - ' . $date->format('M j, Y');
    }
    if ($status === 'complete') {
        $tooltip .= ' (Completed)';
    } elseif ($status === 'missed') {
        $tooltip .= ' (Missed)';
    }
@endphp

<div
    {{
        $attributes->class([
            'group relative flex aspect-square cursor-default items-center justify-center rounded-md border text-xs font-medium transition-all duration-200',
            $colorClass,
            'hover:z-10 hover:scale-110' => $status !== 'pending',
        ])
    }}
    x-data
    x-tooltip="'{{ $tooltip }}'"
>
    {{ $day }}

    @if ($status === 'complete')
        <div class="absolute inset-0 hidden animate-pulse rounded-md bg-white/20 group-hover:block"></div>
    @endif
</div>
