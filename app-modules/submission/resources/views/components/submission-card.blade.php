@props([
    'submission' => null,
])

@php
    /** @var \He4rt\IntegrationTwitterApi\DTOs\TweetDTO|null $tweet */
    $tweet =
        $submission instanceof \He4rt\Submission\Models\Submission
            ? $submission->getTweet()
            : $submission;
@endphp

<div class="flex items-center justify-center">
    <div
        class="w-full max-w-[550px] overflow-hidden rounded-xl border border-gray-200 bg-white font-sans shadow-sm dark:border-gray-700/80 dark:bg-gray-900"
    >
        @if ($tweet)
            {{-- Real Content --}}
            <div class="p-4 pb-0">
                <div class="flex items-start justify-between">
                    <div class="flex gap-3">
                        <div
                            class="flex h-10 w-10 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700"
                        >
                            <img
                                src="{{ $tweet->author->profilePicture }}"
                                alt="{{ $tweet->author->name }}"
                                class="h-full w-full object-cover"
                            />
                        </div>
                        <div class="flex flex-col">
                            <div class="flex items-center gap-1">
                                <span
                                    class="cursor-pointer text-[15px] font-bold text-gray-900 hover:underline dark:text-white"
                                >
                                    {{ $tweet->author->name }}
                                </span>
                                @if ($tweet->author->isBlueVerified)
                                    <span class="text-sm text-blue-500">
                                        <x-filament::icon icon="heroicon-s-check-badge" class="h-4 w-4" />
                                    </span>
                                @endif
                            </div>
                            <div class="flex items-center gap-1 text-[15px] text-gray-500 dark:text-gray-400">
                                <span>{{ '@' . $tweet->author->userName }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="text-gray-900 dark:text-white">
                        <x-filament::icon icon="heroicon-m-x-mark" class="h-5 w-5" />
                    </div>
                </div>
            </div>
            <div class="px-4 py-3">
                <p class="text-gray-900 dark:text-gray-100">{!! $tweet->getFormattedText() !!}</p>
            </div>

            @if ($tweet->extendedEntities?->media || $tweet->entities?->media)
                @php
                    $media = $tweet->extendedEntities?->media[0] ?? $tweet->entities?->media[0];
                @endphp

                @if ($media)
                    <div
                        class="relative mx-4 mb-3 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700"
                    >
                        <img
                            alt="Tweet media"
                            class="aspect-video w-full object-cover"
                            src="{{ $media->mediaUrlHttps }}"
                        />
                    </div>
                @endif
            @endif

            <div class="flex items-center gap-1 px-4 pb-3 text-[15px] text-gray-500 dark:text-gray-400">
                <span>
                    {{ \Carbon\Carbon::parse($tweet->createdAt)->timezone(config('app.timezone'))->format('g:i A · M j, Y') }}
                </span>
            </div>
            <div class="mx-4 border-t border-gray-200 dark:border-gray-700"></div>
            <div class="flex items-center gap-6 px-4 py-3">
                <div class="group flex items-center gap-2 text-gray-500 dark:text-gray-400">
                    <x-filament::icon
                        icon="heroicon-o-heart"
                        class="h-5 w-5 transition-colors group-hover:text-red-500"
                    />
                    <span class="text-[13px] font-medium text-gray-900 dark:text-gray-100">
                        {{ number_format($tweet->likeCount) }}
                    </span>
                </div>
                <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                    <x-filament::icon icon="heroicon-o-chat-bubble-oval-left" class="h-5 w-5" />
                    <span class="text-[13px] font-medium text-gray-900 dark:text-gray-100">
                        {{ number_format($tweet->replyCount) }}
                    </span>
                </div>
                <div class="flex items-center gap-2 text-gray-500 dark:text-gray-400">
                    <x-filament::icon icon="heroicon-o-arrow-path-rounded-square" class="h-5 w-5" />
                    <span class="text-[13px] font-medium text-gray-900 dark:text-gray-100">
                        {{ number_format($tweet->retweetCount) }}
                    </span>
                </div>
            </div>
        @else
            {{-- Skeleton Content --}}
            <div class="animate-pulse">
                <div class="p-4 pb-0">
                    <div class="flex items-start justify-between">
                        <div class="flex w-full gap-3">
                            <div class="h-10 w-10 shrink-0 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                            <div class="flex w-full max-w-[200px] flex-col gap-2">
                                <div class="h-4 w-24 rounded bg-gray-200 dark:bg-gray-700"></div>
                                <div class="h-3 w-16 rounded bg-gray-200 dark:bg-gray-700"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="space-y-2 px-4 py-3">
                    <div class="h-4 w-full rounded bg-gray-200 dark:bg-gray-700"></div>
                    <div class="h-4 w-3/4 rounded bg-gray-200 dark:bg-gray-700"></div>
                    <div class="h-4 w-5/6 rounded bg-gray-200 dark:bg-gray-700"></div>
                </div>
                <div class="mx-4 mb-3 h-48 rounded-xl bg-gray-200 dark:bg-gray-700"></div>
                <div class="px-4 pb-3">
                    <div class="h-3 w-32 rounded bg-gray-200 dark:bg-gray-700"></div>
                </div>
                <div class="mx-4 border-t border-gray-200 dark:border-gray-700"></div>
                <div class="flex items-center gap-6 px-4 py-3">
                    <div class="h-5 w-12 rounded bg-gray-200 dark:bg-gray-700"></div>
                    <div class="h-5 w-12 rounded bg-gray-200 dark:bg-gray-700"></div>
                    <div class="h-5 w-12 rounded bg-gray-200 dark:bg-gray-700"></div>
                </div>
            </div>
        @endif
    </div>
</div>
