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
        Schema::table('archive_categories', function (Blueprint $table) {
            $table->renameColumn('email', 'email_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('archive_categories', function (Blueprint $table) {
            $table->renameColumn('email_address', 'email');
        });
    }
};
