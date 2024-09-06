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
        Schema::create('ac_account_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('category_id');
            $table->string('code', 25);
            $table->string('name', 100);
            $table->integer('range_from');
            $table->integer('range_to');
            $table->integer('is_bank')->default(0);
            $table->integer('is_pop')->default(0);
            $table->integer('active')->default(1);
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac_account_sub_categories');
    }
};
