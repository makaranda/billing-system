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
        Schema::create('customer_vas', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
            $table->integer('customer_id');
            $table->integer('product_id');
            $table->integer('qty');
            $table->string('product_description', 250);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('approved_by');
            $table->string('attach', 20);
            $table->integer('invoice_id')->nullable();
            $table->timestamps(); // created_at and updated_at
            $table->integer('created_by')->nullable();
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_vas');
    }
};
