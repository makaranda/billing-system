<?php

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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50);
            $table->integer('format_id')->nullable();
            $table->integer('reference')->nullable();
            $table->string('subject', 255);
            $table->text('body')->nullable();
            $table->string('reply_to', 255);
            $table->text('recipient_email')->nullable();
            $table->text('cc_email')->nullable();
            $table->string('attachments', 1000)->nullable();
            $table->date('scheduled_to')->nullable();
            $table->integer('created_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->integer('is_sent')->default(0);
            $table->integer('send_attempts')->default(0);
            $table->timestamp('sent_at')->nullable();
            $table->string('response', 500);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
