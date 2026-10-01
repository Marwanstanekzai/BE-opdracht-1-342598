<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllergeenSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $allergenen = [
            ['Id' => 1, 'Naam' => 'Gluten', 'Omschrijving' => 'Dit product bevat gluten', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 2, 'Naam' => 'Gelatine', 'Omschrijving' => 'Dit product bevat gelatine', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 3, 'Naam' => 'AZO-Kleurstof', 'Omschrijving' => 'Dit product bevat AZO-kleurstoffen', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 4, 'Naam' => 'Lactose', 'Omschrijving' => 'Dit product bevat lactose', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 5, 'Naam' => 'Soja', 'Omschrijving' => 'Dit product bevat soja', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
        ];

        DB::table('Allergeen')->upsert($allergenen, ['Id']);
    }
}
