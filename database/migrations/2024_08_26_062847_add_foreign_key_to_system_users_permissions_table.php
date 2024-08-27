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
        Schema::table('system_users_permissions', function (Blueprint $table) {
        // Ensure the userType column is the correct type if not already
        $table->unsignedBigInteger('userType')->nullable()->change();

        // Add the foreign key constraint
        $table->foreign('userType')->references('id')->on('user_privileges')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_users_permissions', function (Blueprint $table) {
           // Drop the foreign key constraint
           $table->dropForeign(['userType']);

           // If necessary, revert the userType column to its original state
           $table->string('userType')->nullable()->change();
        });
    }
};
