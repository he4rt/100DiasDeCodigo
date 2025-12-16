<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\SocialiteUserFactory;
use DutchCodingCompany\FilamentSocialite\Models\SocialiteUser as BaseSocialiteUser;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Override;

class SocialiteUser extends BaseSocialiteUser
{
    /** @use HasFactory<SocialiteUserFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
        'display_name',
        'username',
        'email',
    ];

    #[Override]
    public static function createForProvider(string $provider, SocialiteUserContract $oauthUser, Authenticatable $user): self
    {
        return self::query()
            ->create([
                'user_id' => $user->getKey(),
                'provider' => $provider,
                'provider_id' => $oauthUser->getId(),
                'username' => $oauthUser->getNickname(),
                'display_name' => $oauthUser->getName(),
                'email' => $oauthUser->getEmail() ?? '',
            ]);
    }

    /**
     * @return BelongsTo<User, $this>
     *
     * @phpstan-ignore method.childReturnType
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
