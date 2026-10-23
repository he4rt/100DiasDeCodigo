<?php

declare(strict_types=1);

namespace App\Filament\Shared\Pages;

use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as FilamentLoginPage;
use Filament\Schemas\Schema;

final class LoginPage extends FilamentLoginPage
{
    protected string $view = 'filament.shared.pages.login';

    protected ?string $heading = null;

    public function form(Schema $schema): Schema
    {
        if (!app()->isLocal()) {
            return $schema->components([]);
        }

        return parent::form($schema);
    }

    public function authenticate(): ?LoginResponse
    {
        abort_unless(app()->isLocal(), 404);

        return parent::authenticate();
    }
}
