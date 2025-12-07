@props([
    'submissions',
])

<div class="bg-gray-50 dark:bg-gray-900">
    <div class="mx-auto grid max-w-5xl grid-cols-1 gap-8 px-4 sm:px-0 lg:grid-cols-3">
        <div class="space-y-8 lg:col-span-2">
            <div class="flex items-center justify-between">
                <h2 class="flex items-center gap-2 text-2xl font-bold text-gray-950 dark:text-white">
                    <x-filament::icon icon="heroicon-m-clock" class="text-primary-500 h-6 w-6" />
                    Timeline
                </h2>
            </div>

            <div class="relative space-y-6">
                @foreach ($submissions as $index => $submission)
                    <x-submission::submission-entry :submission="$submission" />
                @endforeach
            </div>
        </div>

        {{-- Sidebar (Optional) --}}
        <div class="hidden space-y-6 lg:block">
            {{-- Placeholder for sidebar content --}}
        </div>
    </div>
</div>
