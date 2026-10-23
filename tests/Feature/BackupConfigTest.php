<?php

declare(strict_types=1);

use App\Providers\Tools\SpatieBackupServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Notification;
use Spatie\Backup\BackupServiceProvider;
use Spatie\Backup\Notifications\Channels\Discord\DiscordChannel;
use Spatie\Backup\Notifications\Channels\Webhook\WebhookChannel;

it('does not boot the backup package when backups are disabled', function (): void {
    expect(config()->boolean('backup.enabled'))->toBeFalse()
        ->and(app()->getProviders(BackupServiceProvider::class))->toBeEmpty()
        ->and(Artisan::all())->not->toHaveKey('backup:run');
});

it('registers the backup channels under the spatie.backup prefix', function (): void {
    app()->register(SpatieBackupServiceProvider::class);

    expect(Notification::channel('spatie.backup.discord'))->toBeInstanceOf(DiscordChannel::class)
        ->and(Notification::channel('spatie.backup.webhook'))->toBeInstanceOf(WebhookChannel::class);
});

it('loads the backup translations from the package', function (): void {
    app()->register(SpatieBackupServiceProvider::class);

    expect(trans('backup::notifications.backup_failed_subject', ['application_name' => 'app']))
        ->toBe('Failed backup of app');
});

it('notifies through the prefixed discord channel by default', function (): void {
    expect(config('backup.notifications.channels'))->toBe(['spatie.backup.discord']);
});

it('backs up the database only by default', function (): void {
    expect(config('backup.backup.source.files.include'))->toBe([]);
});
