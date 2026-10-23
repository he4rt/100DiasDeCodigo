<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('inbound_webhooks', function (Blueprint $table): void {
            $table->string('status')->default('pending')->index()->after('payload');
            $table->timestamp('processed_at')->nullable()->after('status');
            $table->text('error_message')->nullable()->after('processed_at');
        });
    }

    public function down(): void
    {
        Schema::table('inbound_webhooks', function (Blueprint $table): void {
            $table->dropIndex(['status']);
            $table->dropColumn(['status', 'processed_at', 'error_message']);
        });
    }
};
