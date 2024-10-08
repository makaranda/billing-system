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
        Schema::create('customer_wht_attachments', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('type', 25);
            $table->unsignedBigInteger('receipt_id');
            $table->date('date');
            $table->string('file_name', 255);
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamps(); // created_at and updated_at fields
            $table->integer('status')->default(1);

            // Add indexes if necessary
            $table->index('receipt_id');
            $table->index('uploaded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_wht_attachments');
    }
};
