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
        Schema::create('customer_payment_allocations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('transaction_id');
            $table->unsignedInteger('payment_id');
            $table->date('date');
            $table->string('source_type', 25)->comment('invoice/debit_note');
            $table->unsignedInteger('source_id');
            $table->decimal('allocated_amount', 19, 4);
            $table->unsignedInteger('created_by');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->integer('status')->default(1);
            $table->tinyInteger('is_sync_invoice')->default(0);
            $table->dateTime('invoice_sync_at');
            $table->unsignedInteger('invoice_sync_by')->nullable();
            $table->string('invoice_sync_tr_id', 100);
            $table->tinyInteger('is_sync_payment')->default(0);
            $table->dateTime('payment_sync_at')->nullable();
            $table->unsignedInteger('payment_sync_by');
            $table->string('payment_sync_tr_id', 100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_payment_allocations');
    }
};
