<?php

namespace Tests\Feature;

use App\Models\Leverancier;
use App\Models\Magazijn;
use App\Models\Product;
use App\Models\ProductPerLeverancier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ToevoegenProductLeveringTest extends TestCase
{
    use RefreshDatabase;

    public function test_magazijnmedewerker_can_view_delivery_form(): void
    {
        $medewerker = User::factory()->create([
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

        $mintnopjes = Product::create([
            'Naam' => 'Mintnopjes',
            'Barcode' => '8719587231278',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $response = $this->actingAs($medewerker)->get(
            route('levering.create', ['leverancierId' => $venco->Id, 'productId' => $mintnopjes->Id])
        );

        $response->assertStatus(200);
        $response->assertSee('Levering Product');
        $response->assertSee('Venco');
        $response->assertSee('Bert van Linge');
        $response->assertSee('L1029384719');
        $response->assertSee('06-28493827');
        $response->assertSee('Mintnopjes');
        $response->assertSee('Aantal producteenheden');
        $response->assertSee('Datum eerstvolgende levering');
        $response->assertSee('Sla op');
    }

    public function test_user_story_2_scenario_1_mintnopjes_van_venco(): void
    {
        $medewerker = User::factory()->create([
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

        $mintnopjes = Product::create([
            'Naam' => 'Mintnopjes',
            'Barcode' => '8719587231278',
            'IsActief' => 1,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $magazijn = Magazijn::create([
            'ProductId' => $mintnopjes->Id,
            'VerpakkingsEenheid' => 5,
            'AantalAanwezig' => 453,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        // Existing previous delivery
        ProductPerLeverancier::create([
            'LeverancierId' => $venco->Id,
            'ProductId' => $mintnopjes->Id,
            'DatumLevering' => '2024-10-09',
            'Aantal' => 23,
            'DatumEerstVolgendeLevering' => '2024-10-16',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        // Submit new delivery: 25 units, next delivery 29 mei 2024 (2024-05-29)
        $response = $this->actingAs($medewerker)->post(
            route('levering.store', ['leverancierId' => $venco->Id, 'productId' => $mintnopjes->Id]),
            [
                'aantal' => 25,
                'datum_eerstvolgende_levering' => '2024-05-29',
            ]
        );

        $response->assertRedirect(route('leverancier.producten', $venco->Id));

        // Follow redirect and assert changes are visible
        $followResponse = $this->actingAs($medewerker)->get(route('leverancier.producten', $venco->Id));
        $followResponse->assertStatus(200);

        // Check warehouse stock increased: 453 + 25 = 478
        $magazijn->refresh();
        $this->assertEquals(478, $magazijn->AantalAanwezig);
        $followResponse->assertSee('478');

        // Check new delivery stored in database
        $this->assertDatabaseHas('ProductPerLeverancier', [
            'LeverancierId' => $venco->Id,
            'ProductId' => $mintnopjes->Id,
            'Aantal' => 25,
            'DatumEerstVolgendeLevering' => '2024-05-29',
        ]);
    }

    public function test_user_story_2_scenario_2_winegums_van_basset_inactive_product(): void
    {
        $medewerker = User::factory()->create([
            'role' => 'magazijnmedewerker',
        ]);

        $basset = Leverancier::create([
            'Naam' => 'Basset',
            'ContactPersoon' => 'Joyce Stelterberg',
            'LeverancierNummer' => 'L1023845773',
            'Mobiel' => '06-48293823',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        // IsActief is false/0 for Winegums
        $winegums = Product::create([
            'Naam' => 'Winegums',
            'Barcode' => '8719587327527',
            'IsActief' => 0,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $magazijn = Magazijn::create([
            'ProductId' => $winegums->Id,
            'VerpakkingsEenheid' => 3,
            'AantalAanwezig' => null,
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $initialDeliveryCount = ProductPerLeverancier::count();

        // Submit delivery for Winegums: 30 units and today's date
        $response = $this->actingAs($medewerker)->post(
            route('levering.store', ['leverancierId' => $basset->Id, 'productId' => $winegums->Id]),
            [
                'aantal' => 30,
                'datum_eerstvolgende_levering' => now()->format('Y-m-d'),
            ]
        );

        $response->assertStatus(200);

        // Exact required message from Scenario 02
        $response->assertSee('Het product Winegums van de leverancier Basset wordt niet meer geproduceerd');

        // 4-second redirect back to Geleverde producten van Basset
        $response->assertSee('4000');
        $response->assertSee(route('leverancier.producten', $basset->Id));

        // Ensure stock was NOT modified
        $magazijn->refresh();
        $this->assertNull($magazijn->AantalAanwezig);

        // Ensure no new delivery was added
        $this->assertEquals($initialDeliveryCount, ProductPerLeverancier::count());
    }

    public function test_delivery_validation_requires_positive_aantal(): void
    {
        $medewerker = User::factory()->create([
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

        $mintnopjes = Product::create([
            'Naam' => 'Mintnopjes',
            'Barcode' => '8719587231278',
            'DatumAangemaakt' => now(),
            'DatumGewijzigd' => now(),
        ]);

        $response = $this->actingAs($medewerker)->post(
            route('levering.store', ['leverancierId' => $venco->Id, 'productId' => $mintnopjes->Id]),
            [
                'aantal' => 0,
            ]
        );

        $response->assertSessionHasErrors('aantal');
    }
}
