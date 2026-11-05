<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Vul de tabel Contact met de testgegevens uit BE-opdracht 03.
     */
    public function run(): void
    {
        $now = now();
        $contacts = [
            ['Id' => 1, 'Straat' => 'Van Gilslaan', 'Huisnummer' => '34', 'Postcode' => '1045CB', 'Stad' => 'Hilvarenbeek', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 2, 'Straat' => 'Den Dolderpad', 'Huisnummer' => '2', 'Postcode' => '1067RC', 'Stad' => 'Utrecht', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 3, 'Straat' => 'Fredo Raalteweg', 'Huisnummer' => '257', 'Postcode' => '1236OP', 'Stad' => 'Nijmegen', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 4, 'Straat' => 'Bertrand Russellhof', 'Huisnummer' => '21', 'Postcode' => '2034AP', 'Stad' => 'Den Haag', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 5, 'Straat' => 'Leon van Bonstraat', 'Huisnummer' => '213', 'Postcode' => '145XC', 'Stad' => 'Lunteren', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
            ['Id' => 6, 'Straat' => 'Bea van Lingenlaan', 'Huisnummer' => '234', 'Postcode' => '2197FG', 'Stad' => 'Sint Pancras', 'IsActief' => 1, 'Opmerking' => null, 'DatumAangemaakt' => $now, 'DatumGewijzigd' => $now],
        ];

        DB::table('Contact')->upsert($contacts, ['Id']);
    }
}
