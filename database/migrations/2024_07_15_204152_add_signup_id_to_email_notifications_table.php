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
        Schema::table('email_notifications', function (Blueprint $table) {
            $table->foreignId('signup_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('email_notifications', function (Blueprint $table) {
            $table->dropForeign(['signup_id']);
            $table->dropColumn('signup_id');
        });
    }
};
