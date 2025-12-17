<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\SocialiteUser;
use He4rt\IntegrationTwitterApi\TwitterApiClient;
use He4rt\User\Actions\RefreshUserSubmissions;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(TwitterApiClient $client, RefreshUserSubmissions $action): int
    {
        $user = SocialiteUser::query()->latest()->first();

        $action->for($user->user);

        return 0;
    }
}
