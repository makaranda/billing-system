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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('hotel_id');
            $table->unsignedInteger('bank_id');
            $table->unsignedInteger('currency_id');
            $table->unsignedInteger('account_id')->comment('Nominal Account ID');
            $table->string('account_type', 25)->default('savings')->comment('savings/current');
            $table->string('account_code', 25);
            $table->string('account_no', 50);
            $table->string('account_name', 255);
            $table->decimal('od_limit', 16, 2)->default(0.00);
            $table->unsignedInteger('last_cheque_no')->default(0);
            $table->decimal('balance', 16, 2)->default(0.00);
            $table->string('payment_method', 25)->comment('Default Payment Method');
            $table->unsignedInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
