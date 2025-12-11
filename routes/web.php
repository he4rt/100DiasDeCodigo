<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::get('/login', fn () => to_route(route: 'filament.app.auth.login'));
