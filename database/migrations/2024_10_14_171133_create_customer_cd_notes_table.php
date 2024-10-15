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
        Schema::create('customer_cd_notes', function (Blueprint $table) {
            $table->id();  // This automatically creates an auto-incrementing 'id' field
            $table->string('type', 25);
            $table->string('cdn_no', 25);
            $table->unsignedInteger('customer_id');
            $table->date('date');
            $table->decimal('amount', 19, 4)->default(0.0000);
            $table->decimal('total_credit_notes', 19, 4)->default(0.0000);
            $table->decimal('total_receipts', 19, 4)->default(0.0000);
            $table->decimal('allocated_amount', 19, 4)->default(0.0000);
            $table->unsignedInteger('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedInteger('is_posted')->default(0);
            $table->unsignedInteger('posted_by')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->unsignedInteger('is_allocated')->default(0);
            $table->unsignedInteger('is_exported')->default(0);
            $table->unsignedInteger('exported_by')->nullable();
            $table->timestamp('exported_at')->nullable();
            $table->string('transaction_id', 75)->nullable();
            $table->unsignedInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_cd_notes');
    }
};
