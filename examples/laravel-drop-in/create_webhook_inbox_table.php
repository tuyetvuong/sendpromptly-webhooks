<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('webhook_inbox', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->unique(); // Prefer X-SP-Message-Id
            $table->string('event_key')->nullable();
            $table->string('signature')->nullable();
            $table->unsignedBigInteger('timestamp')->nullable();
            $table->string('status')->default('pending'); // pending|completed|failed|dlq
            $table->json('payload')->nullable();
            $table->text('raw_body')->nullable(); // optional; keep if you need forensic replay/debug
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_inbox');
    }
};
