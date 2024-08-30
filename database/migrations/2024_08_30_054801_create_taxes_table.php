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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->string('code',25);
            $table->string('name',25);
            $table->double('rate');
            $table->integer('nominal_account_id');
            $table->string('category',25)->default('other_tax');
            $table->string('calc_method',10);
            $table->integer('calc_order');
            $table->date('added_date')->nullable();
            $table->timestamps();
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxes');
    }
};
