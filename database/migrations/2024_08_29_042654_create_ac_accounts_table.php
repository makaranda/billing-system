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
        Schema::create('ac_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('code',20);
            $table->text('name')->nullable();
            $table->integer('sub_category_id');
            $table->integer('is_control')->default(0);
            $table->string('control_type',25);
            $table->text('special_name')->nullable();
            $table->integer('allow_dr');
            $table->integer('allow_cr');
            $table->integer('is_floating')->default(0);
            $table->integer('created_by');
            $table->integer('active')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ac_accounts');
    }
};
