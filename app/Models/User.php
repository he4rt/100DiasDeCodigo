<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use He4rt\Submission\Models\Concerns\InteractsWithSubmissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

final class User extends Authenticatable implements FilamentUser, HasAvatar, HasMedia
{
    use HasApiTokens;
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use InteractsWithMedia;
    use InteractsWithSubmissions;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
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
        return match ($panel->getId()) {
            'admin' => $this->isAdmin(),
            default => true
        };
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
