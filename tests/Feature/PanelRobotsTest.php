<?php

declare(strict_types=1);

use App\Models\User;

const NOINDEX_META = '<meta name="robots" content="noindex, nofollow" />';

it('marks the admin panel as noindex', function (): void {
    config()->set('he4rt.admins', ['admin']);
    $this->actingAs(User::factory()->create(['username' => 'admin']));

    $this->get('/admin')
        ->assertOk()
        ->assertSeeHtml(NOINDEX_META);
});

it('marks the app panel as noindex', function (): void {
    $this->get('/app/login')
        ->assertOk()
        ->assertSeeHtml(NOINDEX_META);
});

it('does not mark the public portal as noindex', function (): void {
    $this->get('/')
        ->assertOk()
        ->assertDontSeeHtml('content="noindex');
});
