<?php

declare(strict_types=1);

namespace He4rt\Portal\Pages;

use App\Models\User;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Eloquent\Collection;

class PublicUserProfilePage extends Page
{
    public User $user;

    /** @var Collection<int, Submission> */
    public Collection $submissions;

    /** @var array<string, int> */
    public array $stats = [];

    /** @var array{likes: int, retweets: int, replies: int, quotes: int, views: int} */
    public array $twitterMetrics = [
        'likes' => 0,
        'retweets' => 0,
        'replies' => 0,
        'quotes' => 0,
        'views' => 0,
    ];

    public bool $showRestartButton = false;

    protected Width|string|null $maxContentWidth = Width::Full;

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'portal::filament.guest.pages.public-user-profile-page';

    protected static ?string $slug = 'u/{username}';

    public function getHeading(): string
    {
        return '';
    }

    public function getSubheading(): ?string
    {
        return null;
    }

    public function mount(string $username): void
    {
        $this->user = User::query()->where('username', $username)->firstOrFail();

        $this->submissions = $this->user->submissions()
//            ->where('status', SubmissionStatus::Approved)
            ->latest('submitted_at')
            ->get();

        $this->stats = $this->user->getSubmissionStats();

        $this->calculateTwitterMetrics();
    }

    protected function calculateTwitterMetrics(): void
    {
        /** @var Submission $submission */
        foreach ($this->submissions as $submission) {
            $tweet = $submission->getTweet();
            $this->twitterMetrics['likes'] += $tweet->likeCount;
            $this->twitterMetrics['retweets'] += $tweet->retweetCount;
            $this->twitterMetrics['replies'] += $tweet->replyCount;
            $this->twitterMetrics['quotes'] += $tweet->quoteCount;
            $this->twitterMetrics['views'] += $tweet->viewCount;
        }
    }
}
