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
        Schema::create('archives', function (Blueprint $table) {
            $table->integer('id')->primary();
            $table->integer('customer_id')->default(0);
            $table->integer('category_id');
            $table->date('archive_date');
            $table->string('name', 100);
            $table->string('description', 250);
            $table->string('reference', 100);
            $table->date('reminder_date')->nullable();
            $table->string('file', 250);
            $table->integer('uploaded_by');
            $table->integer('status')->default(1);
            $table->tinyInteger('task_review_completed')->default(0);
            $table->dateTime('task_review_at')->nullable();
            $table->integer('task_review_id')->nullable();

            // Set the table's default charset and collation to utf8mb4
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
