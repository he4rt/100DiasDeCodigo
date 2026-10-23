<?php

declare(strict_types=1);

use App\Enums\FilamentPanel;
use App\Filament\Shared\Pages\LoginPage;
use App\Models\User;
use Filament\Facades\Filament;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    Filament::setCurrentPanel(FilamentPanel::App->value);
});

it('blocks credential login outside local', function (): void {
    // Touch the database before the switch: in production, the lazy migrate:fresh aborts without --force.
    $user = User::factory()->create();
    app()->detectEnvironment(fn (): string => 'production');

    livewire(LoginPage::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'password')
        ->call('authenticate')
        ->assertNotFound();

    $this->assertGuest();
});

it('allows credential login in local', function (): void {
    $user = User::factory()->create();
    app()->detectEnvironment(fn (): string => 'local');

    livewire(LoginPage::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'password')
        ->call('authenticate')
        ->assertHasNoErrors();

    $this->assertAuthenticatedAs($user);
});
