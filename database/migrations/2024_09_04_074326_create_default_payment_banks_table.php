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
        Schema::create('default_payment_banks', function (Blueprint $table) {
            $table->id();
            $table->string('payment_method', 25);
            $table->unsignedInteger('currency_id');
            $table->unsignedInteger('card_type_id');
            $table->unsignedInteger('bank_account_id');
            $table->timestamps();
            $table->unsignedInteger('created_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('default_payment_banks');
    }
};
