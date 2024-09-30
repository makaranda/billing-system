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
        Schema::create('rooming_list', function (Blueprint $table) {
            $table->id();
            $table->integer('booking_no')->nullable();
            $table->integer('room_id')->nullable();
            $table->string('title', 10)->nullable();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('telephone', 25)->nullable();
            $table->string('celphone', 25)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->integer('added_by')->nullable();
            $table->integer('status')->default(1);

            // Additional indexes
            $table->index(['booking_no', 'room_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooming_list');
    }
};
