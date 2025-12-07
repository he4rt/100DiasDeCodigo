<x-filament::page class="">
    <div class="space-y-8 bg-gray-100 dark:bg-gray-900">
        {{-- Header Section --}}
        <x-portal::profile.header
            :user="$this->user"
            :stats="$this->stats"
            :twitter-metrics="$this->twitterMetrics"
        />

        {{-- Submissions Timeline --}}
        <x-portal::profile.timeline :$submissions />
    </div>
</x-filament::page>
