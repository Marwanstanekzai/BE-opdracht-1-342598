<?php

namespace Tests\Feature;

use App\Models\Leverancier;
use App\Models\Magazijn;
use App\Models\Product;
use App\Models\ProductPerLeverancier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeverancierOverzichtTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('leverancier.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_non_magazijnmedewerker_is_forbidden(): void
    {
        $klant = User::factory()->create([
            'role' => 'klant',
        ]);

        $response = $this->actingAs($klant)->get(route('leverancier.index'));
        $response->assertStatus(403);
    }

    public function test_user_story_1_scenario_1_overview_and_delivered_products(): void
    {
        $medewerker = User::factory()->create([
            'name' => 'Magazijnmedewerker',
            'role' => 'magazijnmedewerker',
        ]);

        $venco = Leverancier::create([
            'Naam' => 'Venco',
            'ContactPersoon' => 'Bert van Linge',
            'LeverancierNummer' => 'L1029384719',
            'Mobiel' => '06-28493827',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $basset = Leverancier::create([
            'Naam' => 'Basset',
            'ContactPersoon' => 'Joyce Stelterberg',
            'LeverancierNummer' => 'L1023845773',
            'Mobiel' => '06-48293823',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $mintnopjes = Product::create([
            'Naam' => 'Mintnopjes',
            'Barcode' => '8719587231278',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $schoolkrijt = Product::create([
            'Naam' => 'Schoolkrijt',
            'Barcode' => '8719587326713',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        Magazijn::create([
            'ProductId' => $mintnopjes->Id,
            'VerpakkingsEenheid' => 5,
            'AantalAanwezig' => 453,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        Magazijn::create([
            'ProductId' => $schoolkrijt->Id,
            'VerpakkingsEenheid' => 2.5,
            'AantalAanwezig' => 400,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        // 2 distinct products for Venco, with multiple delivery lines for Mintnopjes
        ProductPerLeverancier::create([
            'LeverancierId' => $venco->Id,
            'ProductId' => $mintnopjes->Id,
            'DatumLevering' => '2024-10-09',
            'Aantal' => 23,
            'DatumEerstVolgendeLevering' => '2024-10-16',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        ProductPerLeverancier::create([
            'LeverancierId' => $venco->Id,
            'ProductId' => $mintnopjes->Id,
            'DatumLevering' => '2024-10-18',
            'Aantal' => 21,
            'DatumEerstVolgendeLevering' => '2024-10-25',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        ProductPerLeverancier::create([
            'LeverancierId' => $venco->Id,
            'ProductId' => $schoolkrijt->Id,
            'DatumLevering' => '2024-10-09',
            'Aantal' => 12,
            'DatumEerstVolgendeLevering' => '2024-10-16',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        // 1 product for Basset
        ProductPerLeverancier::create([
            'LeverancierId' => $basset->Id,
            'ProductId' => $mintnopjes->Id,
            'DatumLevering' => '2024-10-09',
            'Aantal' => 10,
            'DatumEerstVolgendeLevering' => '2024-10-16',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        // Test Overzicht leverancier
        $response = $this->actingAs($medewerker)->get(route('leverancier.index'));
        $response->assertStatus(200);
        $response->assertSee('Overzicht Leverancier');
        $response->assertSee('Venco');
        $response->assertSee('Bert van Linge');
        $response->assertSee('L1029384719');
        $response->assertSee('06-28493827');
        $response->assertSee('📦');

        // Test Geleverde producten screen for Venco
        $responseProducten = $this->actingAs($medewerker)->get(route('leverancier.producten', $venco->Id));
        $responseProducten->assertStatus(200);
        $responseProducten->assertSee('Geleverde Producten');
        $responseProducten->assertSee('Venco');
        $responseProducten->assertSee('Bert van Linge');
        $responseProducten->assertSee('L1029384719');
        $responseProducten->assertSee('06-28493827');
        $responseProducten->assertSee('Mintnopjes');
        $responseProducten->assertSee('453');
        $responseProducten->assertSee('5,0 kg');
        $responseProducten->assertSee('18-10-2024'); // Most recent delivery
        $responseProducten->assertSee('Schoolkrijt');
        $responseProducten->assertSee('400');
        $responseProducten->assertSee('2,5 kg');
        $responseProducten->assertSee('➕');

        // Verify sorting: Mintnopjes (453) should appear before Schoolkrijt (400)
        $this->assertGreaterThan(
            strpos($responseProducten->getContent(), 'Mintnopjes'),
            strpos($responseProducten->getContent(), 'Schoolkrijt')
        );
    }

    public function test_user_story_1_scenario_2_supplier_with_no_products_shows_message_and_redirects(): void
    {
        $medewerker = User::factory()->create([
            'name' => 'Magazijnmedewerker',
            'role' => 'magazijnmedewerker',
        ]);

        $qualityStreet = Leverancier::create([
            'Naam' => 'Quality Street',
            'ContactPersoon' => 'Johan Nooij',
            'LeverancierNummer' => 'L1029234586',
            'Mobiel' => '06-23458456',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $response = $this->actingAs($medewerker)->get(route('leverancier.producten', $qualityStreet->Id));

        $response->assertStatus(200);
        $response->assertSee('Geleverde Producten');
        $response->assertSee('Quality Street');
        $response->assertSee('Johan Nooij');
        $response->assertSee('L1029234586');
        $response->assertSee('06-23458456');

        // Exact required message from Scenario 02
        $response->assertSee('Dit bedrijf heeft tot nu toe geen producten geleverd aan Jamin');

        // 3-second redirect back to leverancier.index
        $response->assertSee('3000');
        $response->assertSee(route('leverancier.index'));
    }
}
