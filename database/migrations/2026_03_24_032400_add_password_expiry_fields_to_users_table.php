<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tracks when the password was last changed (null = not yet tracked)
            $table->timestamp('password_changed_at')->nullable()->after('must_change_password');
            // Admin override: skip the 6-month periodic expiry check for this user
            $table->boolean('password_expiry_exempt')->default(false)->after('password_changed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['password_changed_at', 'password_expiry_exempt']);
        });
    }
};