<?php

declare(strict_types=1);

namespace App\Filament\Shared\Responses;

use Illuminate\Http\RedirectResponse;

final class LogoutResponse implements \Filament\Auth\Http\Responses\Contracts\LogoutResponse
{
    /**
     * {@inheritDoc}
     */
    public function toResponse($request): RedirectResponse
    {
        return to_route('filament.guest.pages.portal-page');
    }
}
