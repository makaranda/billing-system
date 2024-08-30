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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // `id` is an auto-incrementing primary key
            $table->integer('category_id')->nullable();
            $table->string('code', 50)->nullable();
            $table->string('name', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->integer('currency_id')->default(1);
            $table->decimal('price', 16, 2)->default(0.00);
            $table->integer('is_taxable')->default(1);
            $table->string('stock_type', 25)->default('stock');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->integer('status')->default(1);
            $table->integer('Kbilling_product_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
