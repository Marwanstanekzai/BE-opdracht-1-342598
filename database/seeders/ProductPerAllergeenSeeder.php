<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPerAllergeenSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $links = [
            ['Id' => 1, 'ProductId' => 1, 'AllergeenId' => 2, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 2, 'ProductId' => 1, 'AllergeenId' => 1, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 3, 'ProductId' => 1, 'AllergeenId' => 3, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 4, 'ProductId' => 3, 'AllergeenId' => 4, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 5, 'ProductId' => 6, 'AllergeenId' => 5, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 6, 'ProductId' => 9, 'AllergeenId' => 2, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 7, 'ProductId' => 9, 'AllergeenId' => 5, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 8, 'ProductId' => 10, 'AllergeenId' => 2, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 9, 'ProductId' => 12, 'AllergeenId' => 4, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 10, 'ProductId' => 13, 'AllergeenId' => 1, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 11, 'ProductId' => 13, 'AllergeenId' => 4, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 12, 'ProductId' => 13, 'AllergeenId' => 5, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
        ];

        DB::table('ProductPerAllergeen')->upsert($links, ['Id']);
    }
}
