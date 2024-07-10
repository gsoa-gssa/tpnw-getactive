<?php

use App\Models\Canton;
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
        Schema::create('cantons', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('name');
            $table->string('code', 2)->unique();
            $table->foreignId('user_id')->constrained();
        });

        // Insert all swiss cantons with their names in all languages and user id 1
        $cantons = [
            ['code' => 'AG', 'name' => ['de' => 'Aargau', 'fr' => 'Argovie', 'it' => 'Argovia', 'en' => 'Aargau']],
            ['code' => 'AI', 'name' => ['de' => 'Appenzell Innerrhoden', 'fr' => 'Appenzell Rhodes-Intérieures', 'it' => 'Appenzello Interno', 'en' => 'Appenzell Innerrhoden']],
            ['code' => 'AR', 'name' => ['de' => 'Appenzell Ausserrhoden', 'fr' => 'Appenzell Rhodes-Extérieures', 'it' => 'Appenzello Esterno', 'en' => 'Appenzell Ausserrhoden']],
            ['code' => 'BE', 'name' => ['de' => 'Bern', 'fr' => 'Berne', 'it' => 'Berna', 'en' => 'Bern']],
            ['code' => 'BL', 'name' => ['de' => 'Basel-Landschaft', 'fr' => 'Bâle-Campagne', 'it' => 'Basilea Campagna', 'en' => 'Basel-Landschaft']],
            ['code' => 'BS', 'name' => ['de' => 'Basel-Stadt', 'fr' => 'Bâle-Ville', 'it' => 'Basilea Città', 'en' => 'Basel-Stadt']],
            ['code' => 'FR', 'name' => ['de' => 'Freiburg', 'fr' => 'Fribourg', 'it' => 'Friburgo', 'en' => 'Fribourg']],
            ['code' => 'GE', 'name' => ['de' => 'Genf', 'fr' => 'Genève', 'it' => 'Ginevra', 'en' => 'Geneva']],
            ['code' => 'GL', 'name' => ['de' => 'Glarus', 'fr' => 'Glaris', 'it' => 'Glarona', 'en' => 'Glarus']],
            ['code' => 'GR', 'name' => ['de' => 'Graubünden', 'fr' => 'Grisons', 'it' => 'Grigioni', 'en' => 'Graubünden']],
            ['code' => 'JU', 'name' => ['de' => 'Jura', 'fr' => 'Jura', 'it' => 'Giura', 'en' => 'Jura']],
            ['code' => 'LU', 'name' => ['de' => 'Luzern', 'fr' => 'Lucerne', 'it' => 'Lucerna', 'en' => 'Lucerne']],
            ['code' => 'NE', 'name' => ['de' => 'Neuenburg', 'fr' => 'Neuchâtel', 'it' => 'Neuchâtel', 'en' => 'Neuchâtel']],
            ['code' => 'NW', 'name' => ['de' => 'Nidwalden', 'fr' => 'Nidwald', 'it' => 'Nidvaldo', 'en' => 'Nidwalden']],
            ['code' => 'OW', 'name' => ['de' => 'Obwalden', 'fr' => 'Obwald', 'it' => 'Obvaldo', 'en' => 'Obwalden']],
            ['code' => 'SG', 'name' => ['de' => 'St. Gallen', 'fr' => 'Saint-Gall', 'it' => 'San Gallo', 'en' => 'St. Gallen']],
            ['code' => 'SH', 'name' => ['de' => 'Schaffhausen', 'fr' => 'Schaffhouse', 'it' => 'Sciaffusa', 'en' => 'Schaffhausen']],
            ['code' => 'SO', 'name' => ['de' => 'Solothurn', 'fr' => 'Soleure', 'it' => 'Soletta', 'en' => 'Solothurn']],
            ['code' => 'SZ', 'name' => ['de' => 'Schwyz', 'fr' => 'Schwytz', 'it' => 'Svitto', 'en' => 'Schwyz']],
            ['code' => 'TG', 'name' => ['de' => 'Thurgau', 'fr' => 'Thurgovie', 'it' => 'Turgovia', 'en' => 'Thurgau']],
            ['code' => 'TI', 'name' => ['de' => 'Tessin', 'fr' => 'Tessin', 'it' => 'Ticino', 'en' => 'Ticino']],
            ['code' => 'UR', 'name' => ['de' => 'Uri', 'fr' => 'Uri', 'it' => 'Uri', 'en' => 'Uri']],
            ['code' => 'VD', 'name' => ['de' => 'Waadt', 'fr' => 'Vaud', 'it' => 'Vaud', 'en' => 'Vaud']],
            ['code' => 'VS', 'name' => ['de' => 'Wallis', 'fr' => 'Valais', 'it' => 'Vallese', 'en' => 'Valais']],
            ['code' => 'ZG', 'name' => ['de' => 'Zug', 'fr' => 'Zoug', 'it' => 'Zugo', 'en' => 'Zug']],
            ['code' => 'ZH', 'name' => ['de' => 'Zürich', 'fr' => 'Zurich', 'it' => 'Zurigo', 'en' => 'Zurich']],
        ];

        foreach ($cantons as $canton) {
            Canton::create([
                'code' => $canton['code'],
                'name' => $canton['name'],
                'user_id' => 1,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cantons');
    }
};
