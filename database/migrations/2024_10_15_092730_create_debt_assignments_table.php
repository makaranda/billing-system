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
        Schema::create('debt_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('customer_id');
            $table->date('assigned_date');
            $table->date('assigned_upto');
            $table->date('collection_date')->nullable();
            $table->unsignedBigInteger('assigned_by');
            $table->timestamps(); // Creates `created_at` and `updated_at` with correct timestamp settings
            $table->integer('status')->default(1);

            // Optional: Add foreign key constraints
            // $table->foreign('user_id')->references('id')->on('system_users')->onDelete('cascade');
            // $table->foreign('assigned_by')->references('id')->on('system_users')->onDelete('cascade');
            // $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debt_assignments');
    }
};
