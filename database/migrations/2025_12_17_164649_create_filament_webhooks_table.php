<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inbound_webhooks', function (Blueprint $table): void {
            $table->uuid('id')->primary();

            $table->string('source');
            $table->string('event');
            $table->longText('url');
            $table->longText('payload');

            $table->timestamps();
            $table->softDeletes();
        });
    }
};
