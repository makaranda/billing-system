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
        Schema::create('customer_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('booking_no');
            $table->unsignedInteger('room_id');
            $table->unsignedInteger('guest_id');
            $table->unsignedInteger('customer_id');
            $table->integer('is_separate')->default(0);
            $table->string('transaction_type', 25);
            $table->string('transaction_reference', 25)->comment('Reference No.');
            $table->unsignedInteger('source_reference')->comment('Reference Id');
            $table->string('payment_method', 25);
            $table->string('reference', 255);
            $table->unsignedInteger('bank_account_id');
            $table->unsignedInteger('nominal_account_id');
            $table->date('transaction_date');
            $table->date('effective_date');
            $table->unsignedInteger('currency_id');
            $table->double('currency_value');
            $table->decimal('amount', 19, 4)->default(0.0000);
            $table->decimal('debits', 19, 4)->default(0.0000);
            $table->decimal('credits', 19, 4)->default(0.0000);
            $table->decimal('balance', 19, 4)->default(0.0000)->comment('Cumulative');
            $table->decimal('customer_balance', 19, 4)->default(0.0000);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->unsignedInteger('created_by');
            $table->integer('is_transfer')->default(0);
            $table->integer('is_reconciled')->default(0);
            $table->integer('is_rd')->default(0);
            $table->unsignedInteger('reconciled_by')->nullable();
            $table->dateTime('reconciled_at')->nullable();
            $table->date('update_date')->nullable();
            $table->string('statement_no', 25)->nullable();
            $table->decimal('amount_received', 16, 2)->default(0.00);
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_transactions');
    }
};
