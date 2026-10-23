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
    app()->detectEnvironment(fn (): string => 'production');
    $user = User::factory()->create();

    livewire(LoginPage::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'password')
        ->call('authenticate')
        ->assertNotFound();

    $this->assertGuest();
});

it('allows credential login in local', function (): void {
    app()->detectEnvironment(fn (): string => 'local');
    $user = User::factory()->create();

    livewire(LoginPage::class)
        ->set('data.email', $user->email)
        ->set('data.password', 'password')
        ->call('authenticate')
        ->assertHasNoErrors();

    $this->assertAuthenticatedAs($user);
});
