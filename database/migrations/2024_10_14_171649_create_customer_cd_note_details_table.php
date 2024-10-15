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
        Schema::create('customer_cd_note_details', function (Blueprint $table) {
            $table->id(); // Automatically creates an auto-incrementing 'id' field
            $table->unsignedInteger('cd_note_id');
            $table->unsignedInteger('sales_account_id');
            $table->string('description', 255);
            $table->string('reference', 25);
            $table->double('tax_percentage');
            $table->text('tax_array'); // Assuming this will store serialized or JSON data
            $table->decimal('net_amount', 19, 4)->default(0.0000);
            $table->decimal('tax_amount', 19, 4)->default(0.0000);
            $table->decimal('gross_amount', 19, 4);
            $table->unsignedInteger('created_by');
            $table->timestamps(); // Creates created_at and updated_at automatically
            $table->unsignedInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_cd_note_details');
    }
};
