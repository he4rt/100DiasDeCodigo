<x-he4rt::card
    href="#"
    x-bind:href="'/u/' + participant.username"
    class="bg-primary/6 relative cursor-pointer rounded-2xl p-5 backdrop-blur-sm transition-all duration-300"
>
    <x-slot:header class="p-1">
        <x-he4rt::partials.author size="lg" src="https://avatars.githubusercontent.com/u/103362" />
    </x-slot:header>

    <x-slot:title class="text-muted-foreground flex items-center justify-center pt-1 text-xs">
        <!-- profile progress-bar -->
        <x-portal::profile.progress :interactive="true" x-bind:total_days="participant.total_days" />
    </x-slot:title>

    <x-slot:description>
        <div
            class="flex flex-row items-center justify-around gap-3"
            :class="{
                'md:justify-between': viewMode === 'list',
                'md:justify-center': viewMode === 'grid',
            }"
        >
            <!-- current streak -->
            <x-portal::participants.wrappers.user-stats-card>
                <x-slot:icon>
                    <x-filament::icon icon="heroicon-s-fire" class="h-4 w-4 text-orange-500" />
                </x-slot:icon>

                <x-slot:title>
                    <span x-text="participant.current_streak"></span>
                </x-slot:title>

                <x-slot:description>
                    Streak
                </x-slot:description>
            </x-portal::participants.wrappers.user-stats-card>

            <!-- likes -->
            <x-portal::participants.wrappers.user-stats-card>
                <x-slot:icon>
                    <x-filament::icon icon="heroicon-o-heart" class="h-4 w-4 text-pink-500" />
                </x-slot:icon>

                <x-slot:title>
                    <span x-text="participant.twitter_metrics.likes"></span>
                </x-slot:title>

                <x-slot:description>
                    Likes
                </x-slot:description>
            </x-portal::participants.wrappers.user-stats-card>

            <!-- views -->
            <x-portal::participants.wrappers.user-stats-card>
                <x-slot:icon>
                    <x-filament::icon icon="heroicon-o-eye" class="h-4 w-4 text-blue-500" />
                </x-slot:icon>

                <x-slot:title>
                    <span x-text="participant.twitter_metrics.views"></span>
                </x-slot:title>

                <x-slot:description>
                    Views
                </x-slot:description>
            </x-portal::participants.wrappers.user-stats-card>
        </div>
    </x-slot:description>
</x-he4rt::card>
