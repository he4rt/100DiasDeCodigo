<?php

declare(strict_types=1);

use He4rt\IntegrationTwitterApi\Http\Controllers\TwitterWebhookController;
use He4rt\IntegrationTwitterApi\Http\Middlewares\StoreTwitterInboundWebhook;
use He4rt\IntegrationTwitterApi\Http\Middlewares\ValidateTwitterInboundRequest;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/twitter', TwitterWebhookController::class)
    ->name('twitter.webhook')
    ->middleware([
        ValidateTwitterInboundRequest::class,
        StoreTwitterInboundWebhook::class,
    ]);
