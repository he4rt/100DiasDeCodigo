<?php

declare(strict_types=1);

namespace He4rt\Submission\Models;

use App\Models\User;
use Carbon\CarbonImmutable;
use He4rt\IntegrationTwitterApi\DTOs\TweetDTO;
use He4rt\Submission\Database\Factories\SubmissionFactory;
use He4rt\Submission\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $approver_id
 * @property string|null $tweet_id
 * @property string $content markdown
 * @property SubmissionStatus|string $status pending, rejected, approved
 * @property CarbonImmutable $submitted_at
 * @property CarbonImmutable|null $approved_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 * @property array<string, mixed>|null $metadata
 * @property-read string|null $progress
 * @property-read User|null $user
 * @property-read User|null $approver
 * @property-read TweetDTO $tweet
 */
class Submission extends Model
{
    /** @use HasFactory<SubmissionFactory> */
    use HasFactory;
    use HasTags;
    use SoftDeletes;

    protected $fillable = [
        'submitted_at',
        'user_id',
        'content',
        'tweet_id',
        'status',
        'approved_at',
        'approver_id',
        'metadata',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function getTweet(): TweetDTO
    {
        return TweetDTO::fromArray($this->metadata);
    }

    /**
     * @return Attribute<string|null, void>
     */
    protected function progress(): Attribute
    {
        return Attribute::make(
            get: function () {
                $text = $this->getTweet()->text;
                // Matches 1/100, 1 / 100
                preg_match('/(\d+)\s*\/\s*(\d+)/', $text, $matches);

                return $matches !== [] ? str($matches[0])->replace(' ', '')->toString() : null;
            }
        );
    }

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'approved_at' => 'datetime',
            'metadata' => 'json',
            'status' => SubmissionStatus::class,
        ];
    }
}
