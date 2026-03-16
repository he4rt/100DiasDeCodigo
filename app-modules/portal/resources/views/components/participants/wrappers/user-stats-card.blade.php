@props (['interactive' => false])

<div class="bg-card/50 rounded-2xl text-center backdrop-blur-sm">
    <x-he4rt::card
        class="gap-0 rounded-2xl border-0 px-5 py-3 pt-2"
        x-bind:class="viewMode === 'grid' ? 'flex items-center' : 'flex items-center px-30'"
        :interactive="$interactive"
    >
        <x-slot:icon class="mb-1 flex items-center justify-center">
            {{ $icon ?? '' }}
        </x-slot:icon>

        <x-slot:description class="flex flex-col items-center justify-center text-sm dark:text-white">
            <span class="font-bold">{{ $title ?? '' }}</span>
            <span>{{ $description ?? '' }}</span>
        </x-slot:description>
    </x-he4rt::card>
</div>
