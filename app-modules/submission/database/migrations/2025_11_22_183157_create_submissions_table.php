<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained('users');
            $table->foreignIdFor(User::class, 'approver_id')
                ->nullable()
                ->constrained('users');
            $table->string('tweet_url')->nullable();
            $table->text('content')->comment('markdown');
            $table->string('status')->comment('pending, rejected, approved');
            $table->timestamp('submitted_at');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
};
