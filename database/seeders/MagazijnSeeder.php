<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MagazijnSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $magazijnData = [
            ['Id' => 1, 'ProductId' => 1, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 453, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 2, 'ProductId' => 2, 'VerpakkingsEenheid' => 2.5, 'AantalAanwezig' => 400, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 3, 'ProductId' => 3, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 1, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 4, 'ProductId' => 4, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 800, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 5, 'ProductId' => 5, 'VerpakkingsEenheid' => 3, 'AantalAanwezig' => 234, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 6, 'ProductId' => 6, 'VerpakkingsEenheid' => 2, 'AantalAanwezig' => 345, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 7, 'ProductId' => 7, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 795, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 8, 'ProductId' => 8, 'VerpakkingsEenheid' => 10, 'AantalAanwezig' => 233, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 9, 'ProductId' => 9, 'VerpakkingsEenheid' => 2.5, 'AantalAanwezig' => 123, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 10, 'ProductId' => 10, 'VerpakkingsEenheid' => 3, 'AantalAanwezig' => null, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 11, 'ProductId' => 11, 'VerpakkingsEenheid' => 2, 'AantalAanwezig' => 367, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 12, 'ProductId' => 12, 'VerpakkingsEenheid' => 1, 'AantalAanwezig' => 467, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 13, 'ProductId' => 13, 'VerpakkingsEenheid' => 5, 'AantalAanwezig' => 20, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
        ];

        DB::table('Magazijn')->upsert($magazijnData, ['Id']);
    }
}
