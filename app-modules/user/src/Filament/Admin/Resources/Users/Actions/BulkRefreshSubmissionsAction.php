<?php

declare(strict_types=1);

namespace He4rt\User\Filament\Admin\Resources\Users\Actions;

use App\Models\SocialiteUser;
use BackedEnum;
use Closure;
use Exception;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use He4rt\User\Jobs\RefreshUserSubmissionJob;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class BulkRefreshSubmissionsAction extends Action
{
    protected string|Htmlable|Closure|null $label = '';

    protected string|Htmlable|Closure|null $tooltip = 'Refresh Twitter Submissions';

    protected string|BackedEnum|Htmlable|Closure|false|null $icon = Heroicon::ArrowPath;

    protected function setUp(): void
    {
        parent::setUp();

        $this->modal();
        $this->modalHeading('Refresh Submissions');
        $this->modalContent(new HtmlString('Are you sure you want to refresh submissions?'));
        $this->action(fn () => $this->refreshSubmissions());
    }

    public static function getDefaultName(): ?string
    {
        return 'bulk-refresh-submissions-action';
    }

    /**
     * @throws Exception
     */
    public function refreshSubmissions(): void
    {
        $users = SocialiteUser::query()->where('provider', 'twitter')
            ->whereNotNull('username')
            ->get();

        foreach ($users as $socialiteUser) {
            dispatch(new RefreshUserSubmissionJob($socialiteUser->user));
        }
    }
}
