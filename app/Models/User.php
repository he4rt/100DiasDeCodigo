<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use He4rt\Submission\Models\Concerns\InteractsWithSubmissions;
use He4rt\Submission\Models\Submission;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $username
 * @property CarbonImmutable|null $email_verified_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, SocialiteUser> $accounts
 * @property-read Collection<int, Submission> $submissions
 */
#[Table(name: 'users')]
#[UseFactory(factoryClass: UserFactory::class)]
final class User extends Authenticatable implements FilamentUser, HasAvatar, HasMedia
{
    use HasApiTokens;
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use InteractsWithMedia;
    use InteractsWithSubmissions;
    use Notifiable;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function isAdmin(): bool
    {
        return in_array($this->username, config('he4rt.admins'));
    }

    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->currentPanel()->isAdmin()) {
            return $this->isAdmin();
        }

        return true;
    }

    public function getFilamentAvatarUrl(): string
    {
        return sprintf('https://github.com/%s.png', $this->username);
    }

    /**
     * @return HasMany<SocialiteUser, $this>
     */
    public function accounts(): HasMany
    {
        return $this->hasMany(SocialiteUser::class, 'user_id', 'id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
