<?php

declare(strict_types=1);

namespace App\Providers;

use App\Filament\Shared\Responses\LogoutResponse as LogoutResponseImpl;
use Filament\Auth\Http\Responses\Contracts\LogoutResponse as LogoutResponseContract;
use Illuminate\Support\ServiceProvider;

class FilamentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LogoutResponseContract::class, LogoutResponseImpl::class);
    }
}
