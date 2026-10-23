<?php

declare(strict_types=1);

namespace App\Enums;

enum FilamentPanel: string
{
    case Admin = 'admin';
    case App = 'app';
    case Guest = 'guest';

    public function isAdmin(): bool
    {
        return $this === self::Admin;
    }

    public function isApp(): bool
    {
        return $this === self::App;
    }

    public function isGuest(): bool
    {
        return $this === self::Guest;
    }
}
