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
        Schema::create('routes_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('main_route');
            $table->string('route')->nullable();
            $table->string('userType');
            $table->integer('show')->default(0);
            $table->integer('add')->default(0);
            $table->integer('edit')->default(0);
            $table->integer('delete')->default(0);
            $table->integer('report')->default(0);
            $table->integer('print')->default(0);
            $table->integer('send')->default(0);
            $table->integer('other')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('routes_permissions');
    }
};
