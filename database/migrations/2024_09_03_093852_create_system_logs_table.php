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
        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Add user_id column
            $table->string('table_name');
            $table->string('operation');
            $table->json('previous_data')->nullable(); // Add previous data column
            $table->json('current_data'); // Add current data column
            $table->string('route_name')->nullable(); // Add route name column
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('system_users')->onDelete('set null'); // Foreign key constraint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_logs');
    }
};
