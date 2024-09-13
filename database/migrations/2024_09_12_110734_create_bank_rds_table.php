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
        Schema::create('bank_rds', function (Blueprint $table) {
            $table->id();
            $table->string('rd_no', 25);
            $table->date('date');
            $table->integer('customer_id');
            $table->integer('bank_account_id');
            $table->string('payment_type', 25);
            $table->integer('payment_id');
            $table->date('payment_date');
            $table->string('method', 25);
            $table->string('reference', 255);
            $table->decimal('payment_amount', 19, 4)->default(0.0000);
            $table->integer('currency_id');
            $table->double('currency_value');
            $table->string('notes', 255);
            $table->integer('is_exported')->default(0);
            $table->integer('exported_by');
            $table->dateTime('exported_at')->nullable();
            $table->string('transaction_id', 75);
            $table->integer('created_by');
            $table->timestamps(0);
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_rds');
    }
};
