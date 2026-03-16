@props ([
    'currentDay' => 15,
])

@php
    $progress = ($currentDay / 100) * 100;
    $milestones = [1, 25, 50, 75, 100];
    $daysRemaining = 100 - $currentDay;
@endphp

<div
    class="group from-primary-500/50 via-primary-500/20 relative mb-8 overflow-hidden rounded-2xl bg-gradient-to-br to-transparent p-[1px]"
>
    {{-- Ambient glow effect --}}
    <div
        class="from-primary-500/20 absolute inset-0 bg-gradient-to-br via-transparent to-purple-500/10 opacity-50 blur-xl transition-opacity duration-500 group-hover:opacity-70"
    ></div>

    <div
        class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-white via-white/95 to-white/90 p-6 backdrop-blur-xl dark:from-gray-900 dark:via-gray-900/95 dark:to-gray-900/90"
    >
        {{-- Background pattern --}}
        <div class="pointer-events-none absolute inset-0 opacity-5">
            <div
                class="absolute inset-0"
                style="
                    background-image: radial-gradient(circle at 1px 1px, currentColor 1px, transparent 0);
                    background-size: 24px 24px;
                "
            ></div>
        </div>

        {{-- Corner accent --}}
        <div
            class="from-primary-500/10 pointer-events-none absolute top-0 right-0 h-32 w-32 rounded-bl-full bg-gradient-to-bl to-transparent"
        ></div>

        <div class="relative">
            {{-- Header section --}}
            <div class="mb-6 flex items-start justify-between">
                <div class="space-y-1">
                    <div class="flex items-center gap-2">
                        <div class="bg-primary-500/10 border-primary-500/20 rounded-lg border p-2">
                            <x-filament::icon icon="heroicon-m-arrow-trending-up" class="text-primary-500 h-4 w-4" />
                        </div>
                        <h2 class="text-xl font-bold tracking-tight text-gray-950 dark:text-white">Seu Progresso</h2>
                    </div>
                    <p class="pl-10 text-sm text-gray-500 dark:text-gray-400">
                        {{ $currentDay }} de 100 dias completados
                    </p>
                </div>

                {{-- Stats badges --}}
                <div class="flex flex-col items-end gap-2">
                    <div
                        class="bg-primary-500/10 border-primary-500/20 flex items-center gap-1.5 rounded-full border px-3 py-1.5"
                    >
                        <x-filament::icon icon="heroicon-m-bolt" class="text-primary-500 h-3.5 w-3.5" />
                        <span class="text-primary-500 text-2xl font-bold">{{ $currentDay }}</span>
                        <span class="text-xs text-gray-500 dark:text-gray-400">%</span>
                    </div>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $daysRemaining }} dias restantes</span>
                </div>
            </div>

            <div class="relative mb-8">
                {{-- Glow effect behind bar --}}
                <div
                    class="from-primary-500/40 via-primary-500/20 absolute h-5 rounded-full bg-gradient-to-r to-transparent blur-lg transition-all duration-700"
                    style="width: {{ $progress }}%"
                ></div>

                {{-- Track --}}
                <div
                    class="relative h-5 overflow-hidden rounded-full border border-gray-200 bg-gray-100 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/30"
                >
                    {{-- Animated fill --}}
                    <div
                        class="from-primary-500 via-primary-500 to-primary-500/80 absolute inset-y-0 left-0 rounded-full bg-gradient-to-r transition-all duration-700 ease-out"
                        style="width: {{ $progress }}%"
                    >
                        {{-- Shine effect --}}
                        <div
                            class="absolute inset-0 rounded-full bg-gradient-to-b from-white/25 via-transparent to-black/10"
                        ></div>
                        {{-- Animated shimmer --}}
                        <div
                            class="absolute inset-0 animate-pulse rounded-full bg-gradient-to-r from-transparent via-white/20 to-transparent"
                        ></div>
                    </div>

                    {{-- Tick marks every 10% --}}
                    <div class="absolute inset-0 flex justify-between px-[1px]">
                        @foreach (range(0, 10) as $i)
                            <div class="h-full w-px bg-gray-200/30 dark:bg-gray-700/30"></div>
                        @endforeach
                    </div>
                </div>

                {{-- Milestone markers --}}
                <div class="pointer-events-none absolute inset-0 flex h-5 items-center">
                    @foreach ($milestones as $milestone)
                        @php
                            $position = $milestone;
                            $isCompleted = $currentDay >= $milestone;
                        @endphp
                        <div
                            class="absolute z-10 -translate-x-1/2 transition-all duration-300 hover:scale-125"
                            style="left: {{ $position }}%"
                        >
                            @if ($isCompleted)
                                <div class="relative">
                                    <div class="bg-primary-500 absolute inset-0 rounded-full opacity-60 blur-md"></div>
                                    <x-filament::icon
                                        icon="heroicon-s-check-circle"
                                        class="text-primary-500 relative h-6 w-6 rounded-full bg-white fill-white drop-shadow-lg dark:bg-gray-900 dark:fill-gray-900"
                                    />
                                </div>
                            @else
                                <div class="relative">
                                    <div
                                        class="h-6 w-6 rounded-full border-2 border-gray-300 bg-white drop-shadow-sm dark:border-gray-600 dark:bg-gray-900"
                                    ></div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Current position indicator --}}
                <div
                    class="absolute top-full mt-1 -translate-x-1/2 transition-all duration-700"
                    style="left: {{ $progress }}%"
                >
                    <div class="flex flex-col items-center">
                        <div
                            class="border-b-primary-500 h-0 w-0 border-r-[6px] border-b-[6px] border-l-[6px] border-transparent"
                        ></div>
                        <span
                            class="text-primary-500 bg-primary-500/10 border-primary-500/30 rounded-full border px-2 py-0.5 text-[10px] font-bold"
                        >
                            {{ $currentDay }}%
                        </span>
                    </div>
                </div>
            </div>

            {{-- Milestones Legend --}}
            <div class="flex justify-between">
                @foreach ($milestones as $index => $milestone)
                    @php
                        $isCompleted = $currentDay >= $milestone;
                        $nextMilestone = $milestones[$index + 1] ?? 101;
                        $isCurrent = $currentDay >= $milestone && $currentDay < $nextMilestone;
                    @endphp
                    <div
                        @class ([
                            'flex flex-col items-center gap-1 transition-all duration-300',
                            'text-primary-500' => $isCompleted,
                            'text-gray-400 dark:text-gray-600' => !$isCompleted,
                            'scale-110' => $isCurrent,
                        ])
                    >
                        @if ($milestone === 100)
                            <div class="relative">
                                <x-filament::icon
                                    icon="heroicon-s-star"
                                    @class ([ 'h-4 w-4', 'text-primary-500' => $isCompleted, 'text-gray-400 dark:text-gray-600' => !$isCompleted, ])
                                />
                                @if ($isCompleted)
                                    <div class="bg-primary-500/50 absolute inset-0 rounded-full blur-sm"></div>
                                @endif
                            </div>
                        @endif

                        <span @class (['text-xs font-semibold', 'text-primary-500' => $isCurrent])>
                            Dia {{ $milestone }}
                        </span>
                        @if ($isCurrent)
                            <span
                                class="bg-primary-500/20 text-primary-500 border-primary-500/30 rounded-full border px-2 py-0.5 text-[10px]"
                            >
                                Atual
                            </span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
