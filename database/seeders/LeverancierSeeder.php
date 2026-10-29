<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeverancierSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $leveranciers = [
            ['Id' => 1, 'Naam' => 'Venco', 'ContactPersoon' => 'Bert van Linge', 'LeverancierNummer' => 'L1029384719', 'Mobiel' => '06-28493827', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 2, 'Naam' => 'Astra Sweets', 'ContactPersoon' => 'Jasper del Monte', 'LeverancierNummer' => 'L1029284315', 'Mobiel' => '06-39398734', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 3, 'Naam' => 'Haribo', 'ContactPersoon' => 'Sven Stalman', 'LeverancierNummer' => 'L1029324748', 'Mobiel' => '06-24383291', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 4, 'Naam' => 'Basset', 'ContactPersoon' => 'Joyce Stelterberg', 'LeverancierNummer' => 'L1023845773', 'Mobiel' => '06-48293823', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 5, 'Naam' => 'De Bron', 'ContactPersoon' => 'Remco Veenstra', 'LeverancierNummer' => 'L1023857736', 'Mobiel' => '06-34291234', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 6, 'Naam' => 'Quality Street', 'ContactPersoon' => 'Johan Nooij', 'LeverancierNummer' => 'L1029234586', 'Mobiel' => '06-23458456', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
        ];

        DB::table('Leverancier')->upsert($leveranciers, ['Id']);
    }
}
