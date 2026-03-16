@props (['hasTwitterIntegration'])
<x-filament-panels::page>
    {{-- <x-dashboard.progress-overview /> --}}
    <div class="space-y-6">
        @if (!$hasTwitterIntegration)
            <x-filament::section :secondary="true" icon="fab-twitter" heading="Conecte sua conta do Twitter">
                Pra participar do desafio você deve conectar sua conta do Twitter.

                <x-slot name="footer">
                    <x-filament::button tag="a" href="/app/oauth/twitter">Conectar</x-filament::button>
                </x-slot>
            </x-filament::section>
        @endif

        <div class="mb-6 grid grid-cols-2 gap-3 lg:max-w-3xl lg:grid-cols-4">
            <x-stats
                icon="fab-github"
                label="Streak Atual"
                value="{{ auth()->user()->total_days }}"
                suffix="dias"
                color="text-orange-500"
                bgColor="bg-orange-500/10"
            />
            <x-stats
                icon="fas-trophy"
                label="Maior Streak"
                value="{{ auth()->user()->longest_streak }}"
                suffix="dias"
                color="text-yellow-500"
                bgColor="bg-yellow-500/10"
            />
        </div>
        <div class="grid gap-8 lg:grid-cols-3">
            <div class="space-y-8 lg:col-span-2">
                <livewire:submission-calendar :user="auth()->user()" />
            </div>
            <div class="space-y-8">
                <livewire:daily-motivation-section />
                {{-- <livewire:next-milestone-section /> --}}
                {{-- <livewire:community-highlight-section /> --}}
            </div>
        </div>
    </div>
</x-filament-panels::page>
