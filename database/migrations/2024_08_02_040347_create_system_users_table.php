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
        Schema::create('system_users', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('username', 100)->nullable();
            $table->string('password', 250)->nullable();
            $table->integer('privilege')->nullable();
            $table->string('full_name', 255)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->string('receipt_printer_id', 75);
            $table->integer('employee_id');
            $table->string('group_id', 20)->default('OFFICE');
            $table->integer('is_debt_collect')->default(0);
            $table->integer('collection_bureau_id');
            $table->dateTime('last_login_time')->nullable();
            $table->string('last_login_ip', 50)->nullable();
            $table->string('last_login_user_agent', 255)->nullable();
            $table->dateTime('last_online')->nullable();
            $table->integer('session_timeout')->default(3600);
            $table->tinyInteger('tfa_phone')->default(0);
            $table->tinyInteger('tfa_email')->default(0);
            $table->string('otp_code', 25)->nullable();
            $table->integer('status')->default(1);
            $table->integer('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_users');
    }
};
