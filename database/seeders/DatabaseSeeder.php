<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (app()->isLocal()) {
            $admin = User::factory()->admin()->create([
                'name' => 'Linus Torvalds',
                'username' => 'torvalds',
            ]);

            $users = User::factory()
                ->count(10)
                ->create();

            $users->each(function (User $user) use ($admin): void {
                Submission::factory()->count(random_int(3, 5))->for($user)->approved($admin)->create();
                Submission::factory()->count(2)->for($user)->pending()->create();
                Submission::factory()->for($user)->rejected($admin)->create();
            });

        }

    }
}
