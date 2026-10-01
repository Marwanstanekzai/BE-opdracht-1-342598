<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPerLeverancierSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $deliveries = [
            ['Id' => 1, 'LeverancierId' => 1, 'ProductId' => 1, 'DatumLevering' => '2024-10-09', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2024-10-16', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 2, 'LeverancierId' => 1, 'ProductId' => 1, 'DatumLevering' => '2024-10-18', 'Aantal' => 21, 'DatumEerstVolgendeLevering' => '2024-10-25', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 3, 'LeverancierId' => 1, 'ProductId' => 2, 'DatumLevering' => '2024-10-09', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2024-10-16', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 4, 'LeverancierId' => 1, 'ProductId' => 3, 'DatumLevering' => '2024-10-10', 'Aantal' => 11, 'DatumEerstVolgendeLevering' => '2024-10-17', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 5, 'LeverancierId' => 2, 'ProductId' => 4, 'DatumLevering' => '2024-10-14', 'Aantal' => 16, 'DatumEerstVolgendeLevering' => '2024-10-21', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 6, 'LeverancierId' => 2, 'ProductId' => 4, 'DatumLevering' => '2024-10-21', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2024-10-28', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 7, 'LeverancierId' => 2, 'ProductId' => 5, 'DatumLevering' => '2024-10-14', 'Aantal' => 45, 'DatumEerstVolgendeLevering' => '2024-10-21', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 8, 'LeverancierId' => 2, 'ProductId' => 6, 'DatumLevering' => '2024-10-14', 'Aantal' => 30, 'DatumEerstVolgendeLevering' => '2024-10-21', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 9, 'LeverancierId' => 3, 'ProductId' => 7, 'DatumLevering' => '2024-10-12', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2024-10-19', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 10, 'LeverancierId' => 3, 'ProductId' => 7, 'DatumLevering' => '2024-10-19', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => '2024-10-26', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 11, 'LeverancierId' => 3, 'ProductId' => 8, 'DatumLevering' => '2024-10-10', 'Aantal' => 12, 'DatumEerstVolgendeLevering' => '2024-10-17', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 12, 'LeverancierId' => 3, 'ProductId' => 9, 'DatumLevering' => '2024-10-11', 'Aantal' => 1, 'DatumEerstVolgendeLevering' => '2024-10-18', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 13, 'LeverancierId' => 4, 'ProductId' => 10, 'DatumLevering' => '2024-10-16', 'Aantal' => 24, 'DatumEerstVolgendeLevering' => '2023-04-30', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 14, 'LeverancierId' => 5, 'ProductId' => 11, 'DatumLevering' => '2024-10-10', 'Aantal' => 47, 'DatumEerstVolgendeLevering' => '2024-10-17', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 15, 'LeverancierId' => 5, 'ProductId' => 11, 'DatumLevering' => '2024-10-19', 'Aantal' => 60, 'DatumEerstVolgendeLevering' => '2024-10-26', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 16, 'LeverancierId' => 5, 'ProductId' => 12, 'DatumLevering' => '2024-10-11', 'Aantal' => 45, 'DatumEerstVolgendeLevering' => null, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 17, 'LeverancierId' => 5, 'ProductId' => 13, 'DatumLevering' => '2024-10-12', 'Aantal' => 23, 'DatumEerstVolgendeLevering' => null, 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
        ];

        DB::table('ProductPerLeverancier')->upsert($deliveries, ['Id']);
    }
}
