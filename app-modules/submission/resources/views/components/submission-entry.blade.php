@props([
    'submission'/**@var\He4rt\Submission\Models\Submission$submission*/,
])

@php
    /** @var \He4rt\Submission\Models\Submission $submission */
    /** @var \He4rt\IntegrationTwitterApi\DTOs\TweetDTO $tweet */
    $tweet = $submission->getTweet();
    $user = $submission->user;
@endphp

<div class="group is-active relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse">
    <article
        class="hover:border-primary-500/20 dark:hover:border-primary-400/20 group/card rounded-xl border border-gray-200 bg-gray-200 shadow-sm transition-all duration-300 dark:border-gray-800 dark:bg-gray-800"
    >
        <div class="p-4 sm:p-6">
            <div class="flex items-start gap-4">
                {{-- Avatar --}}
                <a
                    href="{{ \He4rt\Portal\Pages\PublicUserProfilePage::getUrl(['username' => $user->username]) }}"
                    class="shrink-0"
                    aria-label="View {{ $user->name }}'s profile"
                >
                    <x-filament::avatar
                        src="{{ $user->getFilamentAvatarUrl() }}"
                        alt="{{ $user->name }}"
                        size="h-10 w-10 sm:h-12 sm:w-12"
                        class="ring-2 ring-white dark:ring-gray-900"
                    />
                </a>

                <div class="min-w-0 flex-1">
                    {{-- Header --}}
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1">
                        <a
                            href="{{ \He4rt\Portal\Pages\PublicUserProfilePage::getUrl(['username' => $user->username]) }}"
                            class="truncate text-sm font-bold text-gray-900 hover:underline sm:text-base dark:text-white"
                        >
                            {{ $user->name }}
                        </a>

                        @if ($user->is_verified ?? false)
                            <x-filament::icon
                                icon="heroicon-m-check-badge"
                                class="h-4 w-4 text-blue-500 sm:h-5 sm:w-5"
                                aria-label="Verified"
                            />
                        @endif

                        <span class="text-xs text-gray-500 sm:text-sm dark:text-gray-400">
                            {{ '@' . $user->username }}
                        </span>

                        <span class="text-gray-300 dark:text-gray-600" aria-hidden="true">·</span>

                        <time
                            class="text-xs text-gray-500 sm:text-sm dark:text-gray-400"
                            datetime="{{ $submission->submitted_at->toIso8601String() }}"
                        >
                            {{ $submission->submitted_at->format('M j') }}
                        </time>
                    </div>

                    {{-- Badges --}}
                    <div class="mt-2 flex items-center gap-2">
                        @if ($submission->progress)
                            <div
                                class="bg-primary-50 dark:bg-primary-950/30 text-primary-600 dark:text-primary-400 ring-primary-600/20 inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium ring-1 ring-inset"
                            >
                                Day {{ $submission->progress }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- External Link --}}
                <a
                    href="{{ $tweet->getUrl() }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="p-1 text-gray-400 transition-colors hover:text-gray-900 dark:hover:text-white"
                    aria-label="View original tweet"
                >
                    <x-filament::icon icon="heroicon-m-arrow-top-right-on-square" class="h-4 w-4 sm:h-5 sm:w-5" />
                </a>
            </div>

            {{-- Content --}}
            <div class="mt-4 pl-0 sm:pl-14 md:pl-16">
                <div
                    class="prose dark:prose-invert max-w-none text-sm leading-relaxed break-words text-gray-900 sm:text-[15px] dark:text-gray-100"
                >
                    {!! $tweet->getFormattedText() !!}
                </div>

                {{-- Media --}}
                @if ($tweet->extendedEntities?->media || $tweet->entities?->media)
                    @php
                        $mediaItems = $tweet->extendedEntities?->media ?? $tweet->entities?->media;
                    @endphp

                    <div class="{{ count($mediaItems) > 1 ? 'grid-cols-2' : 'grid-cols-1' }} mt-3 grid gap-2">
                        @foreach ($mediaItems as $media)
                            @if ($media->type === 'photo')
                                <img
                                    src="{{ $media->mediaUrlHttps }}"
                                    alt="Tweet Media"
                                    class="w-full rounded-xl border border-gray-200 object-cover transition-opacity hover:opacity-95 dark:border-gray-800"
                                    loading="lazy"
                                />
                            @elseif ($media->type === 'video' || $media->type === 'animated_gif')
                                <div
                                    class="relative overflow-hidden rounded-xl border border-gray-200 bg-black dark:border-gray-800"
                                >
                                    <video
                                        src="{{ collect($media->videoInfo['variants'] ?? [])->sortByDesc('bitrate')->first()['url'] ?? '' }}"
                                        controls
                                        class="max-h-[400px] w-full"
                                        poster="{{ $media->mediaUrlHttps }}"
                                        aria-label="Tweet video"
                                    ></video>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                {{-- Metrics --}}
                <div
                    class="mt-4 flex flex-wrap items-center gap-4 text-xs text-gray-500 sm:gap-6 sm:text-sm dark:text-gray-400"
                >
                    <div
                        class="group/metric flex cursor-default items-center gap-1.5 transition-colors hover:text-red-500"
                        title="Likes"
                        aria-label="{{ $tweet->likeCount }} Likes"
                    >
                        <x-filament::icon
                            icon="heroicon-m-heart"
                            class="h-3.5 w-3.5 transition-transform group-hover/metric:scale-110 sm:h-4 sm:w-4"
                        />
                        <span>{{ number_format($tweet->likeCount) }}</span>
                    </div>

                    <div
                        class="group/metric flex cursor-default items-center gap-1.5 transition-colors hover:text-green-500"
                        title="Retweets"
                        aria-label="{{ $tweet->retweetCount }} Retweets"
                    >
                        <x-filament::icon
                            icon="heroicon-m-arrow-path-rounded-square"
                            class="h-3.5 w-3.5 transition-transform group-hover/metric:scale-110 sm:h-4 sm:w-4"
                        />
                        <span>{{ number_format($tweet->retweetCount) }}</span>
                    </div>

                    <div
                        class="group/metric flex cursor-default items-center gap-1.5 transition-colors hover:text-blue-500"
                        title="Replies"
                        aria-label="{{ $tweet->replyCount }} Replies"
                    >
                        <x-filament::icon
                            icon="heroicon-m-chat-bubble-left"
                            class="h-3.5 w-3.5 transition-transform group-hover/metric:scale-110 sm:h-4 sm:w-4"
                        />
                        <span>{{ number_format($tweet->replyCount) }}</span>
                    </div>

                    <div
                        class="group/metric flex cursor-default items-center gap-1.5 transition-colors hover:text-purple-500"
                        title="Quotes"
                        aria-label="{{ $tweet->quoteCount }} Quotes"
                    >
                        <x-filament::icon
                            icon="heroicon-m-chat-bubble-bottom-center-text"
                            class="h-3.5 w-3.5 transition-transform group-hover/metric:scale-110 sm:h-4 sm:w-4"
                        />
                        <span>{{ number_format($tweet->quoteCount) }}</span>
                    </div>

                    <div
                        class="group/metric flex cursor-default items-center gap-1.5 transition-colors hover:text-gray-900 dark:hover:text-white"
                        title="Views"
                        aria-label="{{ $tweet->viewCount }} Views"
                    >
                        <x-filament::icon
                            icon="heroicon-m-chart-bar"
                            class="h-3.5 w-3.5 transition-transform group-hover/metric:scale-110 sm:h-4 sm:w-4"
                        />
                        <span>{{ number_format($tweet->viewCount) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </article>
</div>
