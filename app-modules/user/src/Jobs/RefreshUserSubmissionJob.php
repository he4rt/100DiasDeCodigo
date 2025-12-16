<?php

declare(strict_types=1);

namespace He4rt\User\Jobs;

use App\Models\User;
use He4rt\User\Actions\RefreshUserSubmissions;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RefreshUserSubmissionJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public readonly User $user) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        resolve(RefreshUserSubmissions::class)->for($this->user);
    }
}
