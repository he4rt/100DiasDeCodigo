<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('submissions', function (Blueprint $table): void {
            $table->bigInteger('user_id')
                ->nullable()
                ->change();

            $table->renameColumn('tweet_url', 'tweet_id');

            $table->jsonb('metadata')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('submissions', function (Blueprint $table): void {
            $table->dropColumn('metadata');
        });
    }
};
