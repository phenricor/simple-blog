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
        Schema::table('users', function (Blueprint $table) {
            // Drop email and email_verified_at columns
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');

            // Make the name column unique
            $table->string('name')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Re-add email and email_verified_at columns
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            // Remove the unique constraint from the name column
            $table->dropUnique(['name']);
        });
    }
};
