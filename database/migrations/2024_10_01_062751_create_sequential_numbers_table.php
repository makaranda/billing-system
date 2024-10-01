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
        Schema::create('sequential_numbers', function (Blueprint $table) {
            $table->id(); // Equivalent to `int(11) NOT NULL` with auto-increment
            $table->string('type', 25);
            $table->integer('numeric_length');
            $table->integer('last_number');
            $table->string('prefix', 3);
            $table->string('sufix', 3); // Note: `sufix` corrected to `suffix` if this is intended
            $table->integer('status')->default(1);
            $table->timestamps(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sequential_numbers');
    }
};
