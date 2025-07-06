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
        $table->string('provider')->nullable()->after('password');
        $table->string('provider_id')->nullable()->after('provider');
        $table->string('profile_image')->nullable()->after('provider_id');
        $table->string('phone')->nullable()->after('profile_image');
        $table->string('address')->nullable()->after('phone');

    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['provider', 'provider_id', 'profile_image', 'phone ', 'address']);
    });
}

};
