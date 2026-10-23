<?php

declare(strict_types=1);

use App\Models\SocialiteUser;
use App\Models\User;
use Filament\Facades\Filament;
use He4rt\User\Filament\Admin\Resources\Users\Pages\ListUsers;

use function Pest\Livewire\livewire;

beforeEach(function (): void {
    config()->set('he4rt.admins', ['admin']);
    Filament::setCurrentPanel('admin');

    $this->actingAs(User::factory()->create(['username' => 'admin']));
});

it('sorts users by linked twitter account', function (): void {
    $withTwitter = User::factory()->create();
    SocialiteUser::factory()->for($withTwitter)->create(['provider' => 'twitter']);
    $withoutTwitter = User::factory()->create();

    livewire(ListUsers::class)
        ->loadTable()
        ->sortTable('has_twitter', 'desc')
        ->assertCanSeeTableRecords([$withTwitter, $withoutTwitter], inOrder: true)
        ->assertTableColumnStateSet('has_twitter', true, $withTwitter)
        ->assertTableColumnStateSet('has_twitter', false, $withoutTwitter);
});
