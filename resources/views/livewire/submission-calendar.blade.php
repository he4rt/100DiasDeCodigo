<x-filament::section>
    <x-slot:heading>
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                <x-filament::icon icon="heroicon-m-calendar-days" class="text-primary-500 h-5 w-5" />
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Calendário de Atividades</h3>
            </div>

            <div class="flex flex-col items-center gap-4 text-xs md:flex-row">
                <div class="flex items-center gap-1.5">
                    <div class="bg-primary-500 h-3 w-3 rounded-sm shadow-[0_0_5px_rgba(99,102,241,0.4)]"></div>
                    <span class="text-gray-600 dark:text-gray-400">Completo</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div
                        class="h-3 w-3 rounded-sm border border-gray-200 bg-gray-100 dark:border-gray-700 dark:bg-gray-800"
                    ></div>
                    <span class="text-gray-600 dark:text-gray-400">Pendente</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <div
                        class="h-3 w-3 rounded-sm border border-red-200 bg-red-100 dark:border-red-800 dark:bg-red-900/20"
                    ></div>
                    <span class="text-gray-600 dark:text-gray-400">Perdido</span>
                </div>
            </div>
        </div>
    </x-slot:heading>

    <div class="grid grid-cols-5 gap-2 sm:grid-cols-10">
        @foreach (range(1, 100) as $day)
            @php
                $date = $startDate->clone()->addDays($day - 1);
                $dateString = $date->format('Y-m-d');
                $isToday = $date->isToday();
                $isPast = $date->isPast();
                $hasSubmission = $submissions->has($dateString);

                $status = 'pending';
                if ($hasSubmission) {
                    $status = 'complete';
                } elseif ($isPast && !$isToday) {
                    $status = 'missed';
                }

                // If the user hasn't started yet (no submissions), and it's today or future, it's pending.
                // If it's past and no submissions at all, maybe we shouldn't mark everything as missed?
                // But for "100 days of code", if you started, you started.
                // If submissions is empty, startDate is today. So day 1 is today (pending), day 2 future (pending).
                // Past days won't exist in the loop relative to today if startDate is today.
                // So the logic holds.
            @endphp
            <x-submissions.submission-entry :$day :$status :$date />
        @endforeach
    </div>
</x-filament::section>
