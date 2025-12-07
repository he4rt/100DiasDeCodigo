@props([
    'user',
    'stats',
    'twitterMetrics',
])

<div
    class="relative overflow-hidden rounded-xl bg-gray-50 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
>
    {{-- Banner --}}
    <div class="from-primary/12 to-elevation-surface relative h-32 gap-0 bg-gradient-to-br sm:h-48" role="presentation">
        <div
            class="bg-grid-white/5 absolute inset-0 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))]"
        ></div>
    </div>

    <div class="mx-auto max-w-5xl px-4 pb-6 sm:px-6 sm:pb-10">
        <div class="relative -mt-12 mb-6 flex flex-col gap-6 sm:-mt-16 sm:flex-row">
            {{-- Avatar --}}
            <div class="relative flex shrink-0 justify-center sm:justify-start">
                <div class="rounded-full bg-white p-1.5 dark:bg-gray-900">
                    <x-filament::avatar
                        src="{{ $user->getFilamentAvatarUrl() }}"
                        alt="{{ $user->name }}'s avatar"
                        size="h-24 w-24 sm:h-32 sm:w-32"
                        class="ring-0"
                    />
                </div>
                @if ($user->is_verified ?? false)
                    <div
                        class="absolute right-1/2 bottom-2 translate-x-10 rounded-full bg-blue-500 p-0.5 text-white ring-2 ring-white sm:right-2 sm:translate-x-0 dark:ring-gray-900"
                        title="Verified User"
                    >
                        <x-filament::icon icon="heroicon-m-check-badge" class="h-5 w-5" />
                    </div>
                @endif
            </div>

            {{-- User Info --}}
            <div class="flex-1 space-y-4 pt-2 text-center sm:text-left">
                <div>
                    <div class="flex items-center justify-center gap-2 sm:justify-start">
                        <h1 class="text-2xl font-bold text-gray-950 sm:text-3xl dark:text-white">
                            {{ $user->name }}
                        </h1>
                        @if ($user->is_verified ?? false)
                            <x-filament::icon
                                icon="heroicon-m-check-badge"
                                class="h-6 w-6 text-blue-500"
                                aria-label="Verified"
                            />
                        @endif
                    </div>
                    <p class="text-base font-medium text-gray-500 dark:text-gray-400">
                        {{ '@' . $user->username }}
                    </p>
                </div>

                {{-- Bio --}}
                <p class="mx-auto max-w-2xl text-gray-600 sm:mx-0 dark:text-gray-300">
                    {{ $user->bio ?? 'Building something amazing. 🚀' }}
                </p>

                {{-- Meta Info --}}
                <div
                    class="flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-sm text-gray-500 sm:justify-start dark:text-gray-400"
                >
                    <div class="flex items-center gap-1.5" title="Joined Date">
                        <x-filament::icon icon="heroicon-m-calendar" class="h-4 w-4 text-gray-400" />
                        <span>Joined {{ $user->created_at->format('F Y') }}</span>
                    </div>

                    {{-- Stats --}}
                    <div
                        class="ml-auto flex w-full items-center justify-center gap-4 border-t border-gray-100 pt-3 sm:ml-0 sm:w-auto sm:justify-start sm:border-t-0 sm:pt-0 dark:border-gray-800"
                    >
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-gray-900 dark:text-white">
                                {{ $stats['total_submissions'] }}
                            </span>
                            <span>submissions</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-bold text-gray-900 dark:text-white">{{ $stats['longest_streak'] }}</span>
                            <span>longest streak</span>
                        </div>
                    </div>

                    {{-- Twitter Metrics --}}
                    <div
                        class="flex w-full items-center justify-center gap-4 border-l-0 border-gray-200 pl-0 sm:w-auto sm:justify-start sm:border-l sm:pl-4 dark:border-gray-700"
                    >
                        <div class="flex items-center gap-1.5" title="Total Likes">
                            <x-filament::icon icon="heroicon-c-heart" class="h-4 w-4 text-red-500" />
                            <span class="font-semibold text-gray-700 dark:text-gray-300">
                                {{ number_format($twitterMetrics['likes']) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5" title="Total Retweets">
                            <x-filament::icon
                                icon="heroicon-m-arrow-path-rounded-square"
                                class="h-4 w-4 text-green-500"
                            />
                            <span class="font-semibold text-gray-700 dark:text-gray-300">
                                {{ number_format($twitterMetrics['retweets']) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5" title="Total Replies">
                            <x-filament::icon icon="heroicon-m-chat-bubble-left" class="h-4 w-4 text-blue-500" />
                            <span class="font-semibold text-gray-700 dark:text-gray-300">
                                {{ number_format($twitterMetrics['replies']) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-1.5" title="Total Views">
                            <x-filament::icon icon="heroicon-c-eye" class="h-4 w-4 text-gray-500" />
                            <span class="font-semibold text-gray-700 dark:text-gray-300">
                                {{ number_format($twitterMetrics['views']) }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Tags --}}
                <div class="flex flex-wrap justify-center gap-2 pt-2 sm:justify-start">
                    <span
                        class="bg-primary-50 dark:bg-primary-950/30 text-primary-700 dark:text-primary-400 ring-primary-700/10 dark:ring-primary-400/20 inline-flex items-center rounded-md px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset"
                    >
                        #100DaysOfCode
                    </span>
                    <span
                        class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700 ring-1 ring-gray-600/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-400/20"
                    >
                        #php
                    </span>
                    <span
                        class="inline-flex items-center rounded-md bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-700 ring-1 ring-gray-600/10 ring-inset dark:bg-gray-800 dark:text-gray-300 dark:ring-gray-400/20"
                    >
                        #laravel
                    </span>
                </div>
            </div>
        </div>

        {{-- Progress Bar --}}
        <x-portal::profile.progress :stats="$stats" />
    </div>
</div>
