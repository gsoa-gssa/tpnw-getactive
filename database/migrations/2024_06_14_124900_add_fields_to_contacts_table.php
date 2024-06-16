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
        Schema::table('contacts', function (Blueprint $table) {
            $table->enum("language", ["de", "it", "fr"])->default("de");
            $table->enum("canton", ["AG", "AR", "AI", "BL", "BS", "BE", "FR", "GE", "GL", "GR", "JU", "LU", "NE", "NW", "OW", "SG", "SH", "SZ", "SO", "TG", "TI", "UR", "VD", "VS", "ZG", "ZH"])->default("ZH");
            $table->json("activities")->default("[]");
            $table->unsignedBigInteger("user_responsible_id")->nullable();
            $table->foreign("user_responsible_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn("language");
            $table->dropColumn("canton");
            $table->dropColumn("activities");
            $table->dropForeign(["user_id"]);
            $table->dropColumn("user_id");
        });
    }
};
