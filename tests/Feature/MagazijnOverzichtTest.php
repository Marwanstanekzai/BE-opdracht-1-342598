<?php

namespace Tests\Feature;

use App\Models\Allergeen;
use App\Models\Leverancier;
use App\Models\Magazijn;
use App\Models\Product;
use App\Models\ProductPerLeverancier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MagazijnOverzichtTest extends TestCase
{
    use RefreshDatabase;

    public function test_magazijnmedewerker_can_view_magazijn_index_and_sees_correct_user_name(): void
    {
        $user = User::factory()->create([
            'name' => 'Magazijnmedewerker',
            'email' => 'magazijnmedewerker@gmail.com',
            'role' => 'magazijnmedewerker',
        ]);

        $response = $this->actingAs($user)->get(route('magazijn.index'));

        $response->assertStatus(200);
        $response->assertSee('Magazijnmedewerker');
        $response->assertDontSee('Test Student');
    }

    public function test_user_story_1_scenario_1_shows_delivery_information(): void
    {
        $user = User::factory()->create([
            'name' => 'Magazijnmedewerker',
            'role' => 'magazijnmedewerker',
        ]);

        $product = Product::create([
            'Naam' => 'Mintnopjes',
            'Barcode' => '8719587231278',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        Magazijn::create([
            'ProductId' => $product->Id,
            'VerpakkingsEenheid' => 5,
            'AantalAanwezig' => 453,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $leverancier = Leverancier::create([
            'Naam' => 'Venco',
            'ContactPersoon' => 'Bert van Linge',
            'LeverancierNummer' => 'L1029384719',
            'Mobiel' => '06-28493827',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        ProductPerLeverancier::create([
            'LeverancierId' => $leverancier->Id,
            'ProductId' => $product->Id,
            'DatumLevering' => '2024-10-09',
            'Aantal' => 23,
            'DatumEerstVolgendeLevering' => '2024-10-16',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('levering.show', $product->Id));

        $response->assertStatus(200);
        $response->assertSee('Levering Informatie');
        $response->assertSee('Venco');
        $response->assertSee('Bert van Linge');
        $response->assertSee('L1029384719');
        $response->assertSee('06-28493827');
        $response->assertSee('09-10-2024');
    }

    public function test_user_story_1_scenario_2_no_stock_shows_message_and_redirect_script(): void
    {
        $user = User::factory()->create([
            'name' => 'Magazijnmedewerker',
            'role' => 'magazijnmedewerker',
        ]);

        $product = Product::create([
            'Naam' => 'Winegums',
            'Barcode' => '8719587327527',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        Magazijn::create([
            'ProductId' => $product->Id,
            'VerpakkingsEenheid' => 3,
            'AantalAanwezig' => null,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $leverancier = Leverancier::create([
            'Naam' => 'Basset',
            'ContactPersoon' => 'Joyce Stelterberg',
            'LeverancierNummer' => 'L1023845773',
            'Mobiel' => '06-48293823',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        ProductPerLeverancier::create([
            'LeverancierId' => $leverancier->Id,
            'ProductId' => $product->Id,
            'DatumLevering' => '2024-10-16',
            'Aantal' => 24,
            'DatumEerstVolgendeLevering' => '2023-04-30',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('levering.show', $product->Id));

        $response->assertStatus(200);
        $response->assertSee('Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is: 30-04-2023');
        $response->assertSee('setTimeout');
    }

    public function test_user_story_2_scenario_1_shows_allergen_information(): void
    {
        $user = User::factory()->create([
            'name' => 'Magazijnmedewerker',
            'role' => 'magazijnmedewerker',
        ]);

        $product = Product::create([
            'Naam' => 'Zoute Ruitjes',
            'Barcode' => '8719587323256',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $allergeen = Allergeen::create([
            'Naam' => 'Gluten',
            'Omschrijving' => 'Dit product bevat gluten',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $product->allergenen()->attach($allergeen->Id, [
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('allergeen.show', $product->Id));

        $response->assertStatus(200);
        $response->assertSee('Overzicht Allergenen');
        $response->assertSee('Zoute Ruitjes');
        $response->assertSee('8719587323256');
        $response->assertSee('Gluten');
        $response->assertSee('Dit product bevat gluten');
    }

    public function test_user_story_2_scenario_2_no_allergens_shows_message_and_redirect_script(): void
    {
        $user = User::factory()->create([
            'name' => 'Magazijnmedewerker',
            'role' => 'magazijnmedewerker',
        ]);

        $product = Product::create([
            'Naam' => 'Cola Flesjes',
            'Barcode' => '8719587321237',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $response = $this->actingAs($user)->get(route('allergeen.show', $product->Id));

        $response->assertStatus(200);
        $response->assertSee('In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken');
        $response->assertSee('setTimeout');
    }
}
