<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

final class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $canRegister = $this->app->hasDebugModeEnabled()
            && $this->app->isLocal()
            && $this->hasProviderToRegister()
            && $this->hasEnvEnabled();

        if (! $canRegister) {
            return;
        }

        Log::notice('Registering Telescope Service Provider');

        $this->registerTelescopeServiceProvider();
        $this->setNightMode();
        $this->hideSensitiveRequestDetails();
        $this->setFilter();
    }

    public function setFilter(): void
    {
        Telescope::filter(fn (): bool => true);
        Telescope::filterBatch(fn (): bool => true);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', fn (User $user): bool => in_array($user->email, [

        ]));
    }

    private function hasEnvEnabled(): bool
    {
        return config('telescope.enabled');
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    private function hideSensitiveRequestDetails(): void
    {
        Telescope::hideRequestParameters(['_token']);
        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    private function hasProviderToRegister(): bool
    {
        return class_exists(\Laravel\Telescope\TelescopeServiceProvider::class);
    }

    private function registerTelescopeServiceProvider(): void
    {
        $this->app->register(provider: \Laravel\Telescope\TelescopeServiceProvider::class);
    }

    private function setNightMode(): void
    {
        Telescope::night();
    }
}
