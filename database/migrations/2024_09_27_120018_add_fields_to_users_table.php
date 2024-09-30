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
            $table->integer('user_type')->after('id')->default(2);
            $table->string('last_name',255)->after('name')->nullable();
            $table->string('phone',255)->after('last_name')->nullable();
            $table->string('avatar',255)->after('phone')->nullable();
            $table->string('google2fa_secret',255)->after('avatar')->nullable();
            $table->boolean('auth_verified')->after('google2fa_secret')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('user_type');
            $table->dropColumn('last_name');
            $table->dropColumn('phone');
            $table->dropColumn('avatar');
            $table->dropColumn('google2fa_secret');
            $table->dropColumn('auth_verified');
        });
    }
};
