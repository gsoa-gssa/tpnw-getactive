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
        Schema::table('signups', function (Blueprint $table) {
            $table->enum('status', ['signup', 'confirmed', 'cancelled', 'no-show', 'attended'])->default('signup')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signups', function (Blueprint $table) {
            $table->enum('status', ['signup', 'confirmed', 'cancelled', 'no-show'])->default('signup')->change();
        });
    }
};
