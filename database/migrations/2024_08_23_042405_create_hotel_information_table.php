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
        Schema::create('hotel_information', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->nullable();
            $table->string('address', 250)->nullable();
            $table->string('address_post',250)->nullable();
            $table->string('telephone',50)->nullable();
            $table->string('mobile',50)->nullable();
            $table->string('fax',50)->nullable();
            $table->string('email',50)->nullable();
            $table->string('web',50)->nullable();
            $table->text('tandc')->nullable();
            $table->string('tpin',100)->nullable();
            $table->string('acc_name',250)->nullable();
            $table->string('acc_number',250)->nullable();
            $table->integer('status')->default(1);
            $table->string('logo',255)->nullable();
            $table->text('letter_head')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_information');
    }
};
