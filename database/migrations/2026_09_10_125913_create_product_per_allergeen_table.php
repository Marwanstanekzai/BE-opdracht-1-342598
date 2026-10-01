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
        Schema::create('ProductPerAllergeen', function (Blueprint $table) {
            $table->tinyIncrements('Id');

            $table->unsignedTinyInteger('ProductId');
            $table->unsignedTinyInteger('AllergeenId');

            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking', 250)->nullable();
            $table->dateTime('DatumAangemaakt', 6);
            $table->dateTime('DatumGewijzigd', 6);

            $table->foreign('ProductId')
                ->references('Id')
                ->on('Product');

            $table->foreign('AllergeenId')
                ->references('Id')
                ->on('Allergeen');

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ProductPerAllergeen');
    }
};
