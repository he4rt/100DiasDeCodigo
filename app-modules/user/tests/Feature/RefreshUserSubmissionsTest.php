<?php

declare(strict_types=1);

use App\Models\SocialiteUser;
use He4rt\User\Actions\RefreshUserSubmissions;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Uri;

it('searches the tweets of the user when the advanced query is off', function (): void {
    config()->set('100daysofcode.advanced_query', value: false);
    Http::fake([
        '*/twitter/tweet/advanced_search*' => Http::response(['tweets' => [], 'has_next_page' => false]),
        '*/twitter/user/last_tweets*' => Http::response(['data' => ['tweets' => []]]),
    ]);

    $socialiteUser = SocialiteUser::factory()->create([
        'provider' => 'twitter',
        'username' => 'johndoe',
    ]);

    resolve(RefreshUserSubmissions::class)->for($socialiteUser->user);

    Http::assertSent(fn (Request $request): bool => str_contains($request->url(), 'advanced_search')
        && Uri::of($request->url())->query()->get('query') === '(from:johndoe) (#100DiasDeCodigo)');
});
