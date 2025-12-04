<?php

declare(strict_types=1);

namespace He4rt\Submission\Models;

use App\Models\User;
use He4rt\Submission\Database\Factories\SubmissionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Tags\HasTags;

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
        'tweet_url',
        'status',
        'approved_at',
        'approver_id',
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

    protected function casts(): array
    {
        return [
            'submitted_at' => 'timestamp',
            'approved_at' => 'timestamp',
        ];
    }
}
