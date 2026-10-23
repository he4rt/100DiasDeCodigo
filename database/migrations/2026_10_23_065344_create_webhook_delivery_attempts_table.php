<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('webhook_delivery_attempts', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->uuid('inbound_webhook_id');
            $table->string('action');
            $table->string('status')->default('pending');
            $table->text('error_message')->nullable();
            $table->timestamps();

            $table->foreign('inbound_webhook_id')
                ->references('id')
                ->on('inbound_webhooks')
                ->cascadeOnDelete();

            $table->index('inbound_webhook_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_delivery_attempts');
    }
};
