<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\SocialiteUser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;

/**
 * @extends Factory<SocialiteUser>
 */
final class SocialiteUserFactory extends Factory
{
    protected $model = SocialiteUser::class;

    public function definition(): array
    {
        return [
            'provider' => fake()->word(),
            'provider_id' => fake()->word(),
            'created_at' => Date::now(),
            'updated_at' => Date::now(),
            'username' => fake()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'display_name' => fake()->name(),

            'user_id' => User::factory(),
        ];
    }
}
