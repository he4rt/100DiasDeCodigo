<?php

declare(strict_types=1);

namespace He4rt\User\Filament\Admin\Resources\Users\Actions;

use App\Models\User;
use BackedEnum;
use Closure;
use Exception;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use He4rt\User\Jobs\RefreshUserSubmissionJob;
use Illuminate\Contracts\Support\Htmlable;

class RefreshSubmissionsAction extends Action
{
    protected string|Htmlable|Closure|null $label = '';

    protected string|Htmlable|Closure|null $tooltip = 'Refresh Twitter Submissions';

    protected string|BackedEnum|Htmlable|Closure|false|null $icon = Heroicon::ArrowPath;

    protected function setUp(): void
    {
        $this->action($this->refreshSubmissions(...));
    }

    public static function getDefaultName(): ?string
    {
        return 'refresh-submissions-action';
    }

    /**
     * @throws Exception
     */
    public function refreshSubmissions(User $record): void
    {
        dispatch(new RefreshUserSubmissionJob($record));
    }
}
