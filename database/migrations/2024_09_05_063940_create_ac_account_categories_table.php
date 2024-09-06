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
        Schema::create('ac_account_categories', function (Blueprint $table) {
            $table->id();
            $table->string('code', 25);
            $table->string('name', 100);
            $table->char('pl_bl', 1)->default('');
            $table->integer('sort_order')->default(0);
            $table->integer('group_order')->default(0);
            $table->unsignedInteger('created_by');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->integer('enable')->default(1);
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac_account_categories');
    }
};
