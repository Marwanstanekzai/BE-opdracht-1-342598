<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'magazijnmedewerker@gmail.com'],
            [
                'name' => 'Magazijnmedewerker',
                'password' => bcrypt('password'),
                'role' => 'magazijnmedewerker',
            ]
        );

        User::firstOrCreate(
            ['email' => 'klant@gmail.com'],
            [
                'name' => 'Klant',
                'password' => bcrypt('password'),
                'role' => 'klant',
            ]
        );

        $this->call([
            ProductSeeder::class,
            AllergeenSeeder::class,
            LeverancierSeeder::class,
            MagazijnSeeder::class,
            ProductPerAllergeenSeeder::class,
            ProductPerLeverancierSeeder::class,
        ]);
    }
}
