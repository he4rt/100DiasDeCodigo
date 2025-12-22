@php
    use Filament\Support\Icons\Heroicon;
@endphp

<x-filament-panels::page>
    <x-filament::section
        heading="Match Submissions ({{ $submissionsCount }} left)"
        :description="filled($submission) ? $submission->getKey() : '' "
    >
        @if ($submission)
            <div class="flex justify-center gap-4">
                <x-submission::submission-card :$submission />
                <x-submission::submission-user-profile :submission="$submission" />
            </div>

            <div class="mt-6 flex items-center justify-center gap-4">
                <button
                    wire:click="matchSubmission('rejected')"
                    class="bg-card hover:text-card flex h-16 w-16 items-center justify-center rounded-full border-2 border-red-300 text-red-300 shadow-lg transition-colors hover:bg-red-300 hover:text-red-500"
                >
                    <x-filament::icon :icon="Heroicon::XMark" class="h-8 w-8" />
                </button>
                <button
                    wire:click="matchSubmission('approved')"
                    class="bg-card flex h-16 w-16 items-center justify-center rounded-full border-2 border-green-500 text-green-500 shadow-lg transition-colors hover:bg-green-500 hover:text-green-800"
                >
                    <x-filament::icon :icon="Heroicon::Check" class="h-8 w-8" />
                </button>
            </div>
        @else
            Nenhum post disponível :/
        @endif
    </x-filament::section>
</x-filament-panels::page>
