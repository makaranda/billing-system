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
        Schema::create('customer_transaction_corrections', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedInteger('from_customer_id');
            $table->unsignedInteger('to_customer_id');
            $table->text('description');
            $table->text('transaction_ids');
            $table->unsignedInteger('created_by');
            $table->dateTime('created_time'); // Manually specified created_time
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_transaction_corrections');
    }
};
