<?php

declare(strict_types=1);

namespace He4rt\Portal\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Support\Assets\Js;
use Filament\Support\Enums\Width;
use Filament\Support\Facades\FilamentAsset;
use He4rt\Submission\Models\Submission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\Number;

class ParticipantsPage extends Page
{
    protected string $view = 'portal::filament.guest.pages.participants-page';

    protected static ?string $title = 'Participantes';

    protected static ?string $slug = 'participants';

    protected string $heroTitle = 'Meet the Challengers';

    protected string $subtitle = 'Descubra desenvolvedores que estão superando seus próprios limites com o #100DiasDeCodigo e encontre pessoas para evoluir e programar junto com você';

    /** @var array<int, array<string, mixed>> */
    protected array $participants = [];

    protected Width|string|null $maxContentWidth = Width::Full;

    protected int $participantsCount = 0;

    protected int $totalDaysCount = 0;

    protected int $winnersCount = 0;

    protected float $streakAvg = 0;

    protected int $generalStreakCount = 0;

    public static function abbreviate(int|float $value, int $precision = 1): string
    {
        return $value >= 1000
            ? Number::abbreviate($value, $precision)
            : (string) $value;
    }

    public function getHeading(): string
    {
        return '';
    }

    public function getSubheading(): ?string
    {
        return null;
    }

    public function mount(): void
    {
        FilamentAsset::register([
            Js::make('autoAnimate', Vite::asset('resources/js/autoAnimate.js'))->module(),
        ]);

        $participantsQuery = User::query()
            ->whereHas('submissions');

        $this->participantsCount = (clone $participantsQuery)->count();

        $this->participants = $participantsQuery
            ->get()
            ->map(function (User $user): array {
                $metrics = self::calculateTwitterMetrics($user->submissions);
                $currentStreak = $user->current_streak;
                $totalDays = $user->total_days;

                $this->totalDaysCount += $totalDays;

                if ($totalDays >= 100) {
                    $this->winnersCount++;
                }

                if ($currentStreak) {
                    $this->generalStreakCount += $currentStreak;
                }

                return [
                    'name' => $user->name,
                    'username' => $user->username,
                    'avatar' => $user->getFilamentAvatarUrl(),
                    'total_days' => $totalDays,
                    'current_streak' => $currentStreak,
                    'tags' => ['#php', '#vibecoding', '#laravel', 'alpine.js', '#fullstack'],
                    'twitter_metrics' => [
                        'likes' => static::abbreviate($metrics['likes']),
                        'likes_raw' => $metrics['likes'],
                        'views' => static::abbreviate($metrics['views']),
                        'views_raw' => $metrics['views'],
                    ],
                ];
            })
            ->all();

        $this->streakAvg = $this->participantsCount / $this->generalStreakCount;
    }

    /**
     * @param  Collection<int, Submission>  $submissions
     * @return array{likes:int, views:int}
     */
    protected function calculateTwitterMetrics(Collection $submissions): array
    {
        $metrics = [
            'likes' => 0,
            'views' => 0,
        ];

        /** @var Submission $submission */
        foreach ($submissions as $submission) {
            $tweet = $submission->getTweet();
            $metrics['likes'] += $tweet->likeCount;
            $metrics['views'] += $tweet->viewCount;
        }

        return $metrics;
    }

    /**
     * @return array<int, array{
     *     icon: string,
     *     color: string,
     *     value: int|string,
     *     label: string
     * }>
     */
    protected function getHeroInfo(): array
    {
        return [
            ['icon' => 'heroicon-o-users', 'color' => 'text-primary', 'value' => $this->participantsCount, 'label' => 'Participantes'],
            ['icon' => 'heroicon-o-trophy', 'color' => 'text-green-500', 'value' => $this->winnersCount, 'label' => 'Vencedores'],
            ['icon' => 'heroicon-o-calendar', 'color' => 'text-warning-500', 'value' => $this->totalDaysCount, 'label' => 'Dias no Total'],
            ['icon' => 'heroicon-s-fire', 'color' => 'text-orange-500', 'value' => Number::abbreviate($this->streakAvg, 2), 'label' => 'Média de Streak'],
        ];
    }

    protected function getViewData(): array
    {
        return [
            'title' => $this->heroTitle,
            'counters' => $this->getHeroInfo(),
            'subtitle' => $this->subtitle,
            'participants' => $this->participants,
        ];
    }
}
