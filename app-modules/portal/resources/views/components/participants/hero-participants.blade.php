@props ([
    'counters' => [],
    'title' => '',
    'subtitle' => '',
])

@php
    $words = explode(' ', trim($title));
    $lastWord = array_pop($words);
    $firstPart = implode(' ', $words);
@endphp

<section class="border-border/40 relative overflow-hidden border-b">
    <div class="from-primary/5 absolute inset-0 bg-linear-to-br via-transparent to-purple-500/5"></div>
    <div class="bg-primary/10 absolute top-20 left-10 h-72 w-72 rounded-full blur-3xl"></div>
    <div class="absolute right-10 bottom-10 h-96 w-96 rounded-full bg-purple-500/10 blur-3xl"></div>
    <div class="relative container mx-auto max-w-7xl px-4 py-16">
        <div class="mx-auto max-w-3xl text-center">
            <div
                class="bg-primary/10 text-primary mb-6 inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium"
            >
                <x-filament::icon icon="heroicon-o-users" class="h-4 w-4" />
                Community
            </div>
            <h1 class="mb-4 text-4xl font-bold tracking-tight text-balance md:text-5xl">
                {{ $firstPart }}
                <span class="text-primary">{{ $lastWord }}</span>
            </h1>
            <p class="text-muted-foreground text-lg text-pretty">{{ $subtitle }}</p>
        </div>

        <div class="mx-auto mt-12 grid max-w-4xl grid-cols-2 gap-4 md:grid-cols-4">
            @foreach ($counters as $counter)
                <x-he4rt::card
                    class="bg-primary/3 flex h-28 items-center justify-center gap-0 rounded-2xl"
                    :interactive="false"
                >
                    <x-slot:icon class="mb-1 flex items-center justify-center">
                        <x-filament::icon icon="{{ $counter['icon'] }}" class="h-6 w-6 {{ $counter['color'] }}" />
                    </x-slot:icon>

                    <x-slot:title class="flex items-center justify-center text-center text-2xl font-bold">
                        {{ $counter['value'] }}
                    </x-slot:title>

                    <x-slot:description class="text-light-500 text-xs">
                        {{ $counter['label'] }}
                    </x-slot:description>
                </x-he4rt::card>
            @endforeach
        </div>
    </div>
</section>
