<?php

declare(strict_types=1);

it('redirects a guest from the admin panel to the login shortcut', function (): void {
    $this->get('/admin')
        ->assertRedirect(route('login'));
});

it('redirects the login shortcut to the app login', function (): void {
    $this->get('/login')
        ->assertRedirect(route('filament.app.auth.login'));
});
