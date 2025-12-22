@props([
    'submission' => null,
])

@php
    use Filament\Support\Icons\Heroicon;

    $user = $submission->user;
    $metadata = $submission->metadata;
    $author = $metadata['author'] ?? null;

    $stats = $user?->getSubmissionStats() ?? [
        'current_streak' => 0,
        'longest_streak' => 0,
        'total_days' => 0,
        'total_submissions' => 0,
    ];

    $name = $user?->name ?? ($author['name'] ?? 'Unknown User');
    $username = $user?->username ?? ($author['userName'] ?? 'unknown');
    $avatar = $user?->getFilamentAvatarUrl() ?? ($author['profilePicture'] ?? null);
    $description = $author['description'] ?? null;
    $followers = $author['followers'] ?? 0;
    $following = $author['following'] ?? 0;
@endphp

<aside
    class="min-w-[250px] rounded-xl border border-gray-200 bg-white font-sans shadow-sm dark:border-gray-700/80 dark:bg-gray-900"
>
    <div class="flex flex-col items-center gap-3 p-4 text-center">
        @if ($avatar)
            <div
                class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700"
            >
                <img src="{{ $avatar }}" alt="{{ $name }}" class="h-full w-full object-cover" />
            </div>
        @else
            <div
                class="from-primary to-primary/60 text-primary-foreground flex h-20 w-20 items-center justify-center rounded-full bg-gradient-to-br text-3xl font-bold"
            >
                ?
            </div>
        @endif
        <div>
            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $name }}</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ '@' . $username }}</p>
        </div>

        @if (! $user && $description)
            <p class="mt-1 line-clamp-2 text-xs text-gray-500 dark:text-gray-400">
                {{ $description }}
            </p>
            <div class="mt-2 flex gap-4 text-xs text-gray-500 dark:text-gray-400">
                <span>
                    <strong>{{ number_format($followers) }}</strong>
                    Followers
                </span>
                <span>
                    <strong>{{ number_format($following) }}</strong>
                    Following
                </span>
            </div>
        @endif
    </div>

    <div class="space-y-3 px-4 pb-4">
        @if ($user)
            <div class="space-y-3 rounded-xl bg-gray-50 p-4 dark:bg-gray-800/50">
                <h4 class="flex items-center gap-2 text-sm font-medium text-gray-900 dark:text-white">
                    <x-filament::icon :icon="Heroicon::Trophy" class="text-primary h-5 w-5" />
                    Streak
                </h4>
                <div class="flex justify-between">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['current_streak'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Current</p>
                    </div>
                    <div class="w-px bg-gray-200 dark:bg-gray-700"></div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $stats['longest_streak'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Longest</p>
                    </div>
                </div>
            </div>

            <div class="space-y-3">
                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Your Activity</h4>
                <div class="grid grid-cols-2 gap-2">
                    <div class="rounded-lg bg-gray-50 p-2 text-center dark:bg-gray-800/50">
                        <x-filament::icon :icon="Heroicon::Heart" class="mx-auto mb-1 h-4 w-4 text-gray-400" />
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $stats['total_submissions'] }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Total</p>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-2 text-center dark:bg-gray-800/50">
                        <x-filament::icon :icon="Heroicon::Eye" class="mx-auto mb-1 h-4 w-4 text-gray-400" />
                        <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $stats['total_days'] }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Days</p>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-2 text-center dark:bg-gray-800/50">
                        <x-filament::icon
                            :icon="Heroicon::ArrowTrendingUp"
                            class="mx-auto mb-1 h-4 w-4 text-gray-400"
                        />
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            {{ $stats['total_days'] > 0 ? round(($stats['total_submissions'] / $stats['total_days']) * 100) : 0 }}%
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Consistency</p>
                    </div>
                    <div class="rounded-lg bg-gray-50 p-2 text-center dark:bg-gray-800/50">
                        <x-filament::icon :icon="Heroicon::Trophy" class="mx-auto mb-1 h-4 w-4 text-gray-400" />
                        <p class="text-lg font-bold text-gray-900 dark:text-white">#42</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Leaderboard</p>
                    </div>
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Progress</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $stats['total_days'] }}/100</span>
                </div>
                <div class="h-2 overflow-hidden rounded-full bg-gray-100 dark:bg-gray-800">
                    <div
                        class="bg-primary h-full rounded-full transition-all duration-300"
                        style="width: {{ min(100, $stats['total_days']) }}%"
                    ></div>
                </div>
            </div>

            <div class="mt-4 border-t border-gray-200 pt-4 dark:border-gray-700">
                <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                    <x-filament::icon :icon="Heroicon::Calendar" class="h-5 w-5" />
                    <span>Member since {{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 p-6 text-center dark:border-gray-700">
                <x-filament::icon :icon="Heroicon::UserPlus" class="mx-auto mb-2 h-8 w-8 text-gray-400" />
                <p class="text-sm font-medium text-gray-900 dark:text-white">Not Registered</p>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">This user hasn't joined the platform yet.</p>
            </div>
        @endif
    </div>
</aside>
