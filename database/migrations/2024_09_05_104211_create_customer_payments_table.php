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
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('branch_id');
            $table->string('receipt_no', 25);
            $table->unsignedInteger('mcs_id');
            $table->unsignedInteger('customer_id')->nullable();
            $table->unsignedInteger('bank_account_id');
            $table->date('date')->nullable();
            $table->unsignedInteger('currency_id')->nullable();
            $table->double('currency_value');
            $table->decimal('payment_amount', 19, 4)->default(0.0000);
            $table->decimal('payment', 19, 4)->default(0.0000);
            $table->string('method', 250)->nullable();
            $table->unsignedInteger('bank_id')->default(0);
            $table->string('card_number', 25)->nullable();
            $table->string('reference', 25);
            $table->unsignedInteger('card_type');
            $table->string('auth_number', 25);
            $table->date('added_date')->nullable();
            $table->unsignedInteger('added_user')->nullable();
            $table->tinyInteger('is_posted')->default(0);
            $table->unsignedInteger('posted_by')->nullable();
            $table->dateTime('posted_date')->nullable();
            $table->unsignedInteger('preceipt_printed');
            $table->decimal('allocated_amount', 19, 4)->default(0.0000);
            $table->unsignedInteger('is_allocated')->default(0);
            $table->tinyInteger('is_refund')->default(0);
            $table->decimal('refund_amount', 18, 2)->nullable();
            $table->timestamps(); // `created_at` and `updated_at` columns
            $table->unsignedInteger('status')->default(1);
            $table->date('update_date')->nullable();
            $table->decimal('update_amount', 16, 2)->nullable();
            $table->unsignedInteger('recon_bank_account_id')->nullable();
            $table->string('statement_no', 25)->nullable();
            $table->unsignedInteger('reconciled_by')->nullable();
            $table->timestamp('reconciled_at')->nullable();
            $table->unsignedInteger('is_reconciled')->default(0);
            $table->unsignedInteger('is_exported')->default(0);
            $table->unsignedInteger('exported_by')->nullable();
            $table->dateTime('exported_at')->nullable();
            $table->string('transaction_id', 75);
            $table->text('private_note');
            $table->unsignedInteger('is_deposit')->default(0);
            $table->unsignedInteger('deposit_id')->nullable();
            $table->date('deposit_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_payments');
    }
};
