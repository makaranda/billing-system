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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('emp_no', 255)->nullable();
            $table->string('emp_name', 255)->nullable();
            $table->string('emp_dob', 25)->nullable();
            $table->integer('emp_department')->nullable();
            $table->integer('emp_shift')->nullable();
            $table->string('emp_off_day', 25)->nullable();
            $table->integer('emp_position');
            $table->string('emp_telephone', 50)->nullable();
            $table->string('emp_email', 255)->nullable();
            $table->date('emp_date_join')->nullable();
            $table->string('emp_gender', 10)->nullable();
            $table->string('emp_status',110)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
