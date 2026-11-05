<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Maak de tabel Contact aan en koppel deze via ContactId aan Leverancier.
     */
    public function up(): void
    {
        Schema::create('Contact', function (Blueprint $table) {
            $table->tinyIncrements('Id');
            $table->string('Straat', 100);
            $table->string('Huisnummer', 10);
            $table->string('Postcode', 10);
            $table->string('Stad', 100);

            // Systeemvelden
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 250)->nullable()->default(null);
            $table->dateTime('DatumAangemaakt', 6);
            $table->dateTime('DatumGewijzigd', 6);

            $table->engine = 'InnoDB';
        });

        Schema::table('Leverancier', function (Blueprint $table) {
            $table->unsignedTinyInteger('ContactId')->nullable()->after('Mobiel');

            $table->foreign('ContactId')
                ->references('Id')
                ->on('Contact');
        });
    }

    /**
     * Draai de migratie terug.
     */
    public function down(): void
    {
        Schema::table('Leverancier', function (Blueprint $table) {
            $table->dropForeign(['ContactId']);
            $table->dropColumn('ContactId');
        });

        Schema::dropIfExists('Contact');
    }
};
