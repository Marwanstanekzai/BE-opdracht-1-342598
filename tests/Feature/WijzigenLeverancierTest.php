<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WijzigenLeverancierTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test server-side pagination op het overzicht Wijzigen Leveranciers (maximaal 4 records per pagina).
     */
    public function test_wijzigen_leveranciers_overview_uses_server_side_pagination_of_4_records(): void
    {
        $this->seed();
        $medewerker = User::where('email', 'magazijnmedewerker@gmail.com')->first();

        // Pagina 1 toont de eerste 4 leveranciers (Venco, Astra Sweets, Haribo, Basset)
        $responsePage1 = $this->actingAs($medewerker)->get(route('leverancier.wijzigen'));
        $responsePage1->assertStatus(200);
        $responsePage1->assertSee('Overzicht Leveranciers');
        $responsePage1->assertSee('Venco');
        $responsePage1->assertSee('Astra Sweets');
        $responsePage1->assertSee('Haribo');
        $responsePage1->assertSee('Basset');
        $responsePage1->assertDontSee('De Bron');
        $responsePage1->assertDontSee('Quality Street');

        // Pagina 2 toont de overige 2 leveranciers (De Bron, Quality Street)
        $responsePage2 = $this->actingAs($medewerker)->get(route('leverancier.wijzigen', ['page' => 2]));
        $responsePage2->assertStatus(200);
        $responsePage2->assertSee('De Bron');
        $responsePage2->assertSee('Quality Street');
        $responsePage2->assertDontSee('Venco');
    }

    /**
     * User Story 01 — Scenario 01: Wijzigen van Astra Sweets lukt en toont succesmelding met 3s redirect.
     */
    public function test_scenario_01_wijzigen_astra_sweets_succeeds(): void
    {
        $this->seed();
        $medewerker = User::where('email', 'magazijnmedewerker@gmail.com')->first();

        // Stap 1: Open Leverancier Details van Astra Sweets (Id = 2)
        $detailsResponse = $this->actingAs($medewerker)->get(route('leverancier.details', 2));
        $detailsResponse->assertStatus(200);
        $detailsResponse->assertSee('Leverancier Details');
        $detailsResponse->assertSee('Astra Sweets');
        $detailsResponse->assertSee('06-39398734');
        $detailsResponse->assertSee('Den Dolderpad');
        $detailsResponse->assertSee('Wijzig');

        // Stap 2: Open het wijzigingsformulier
        $editResponse = $this->actingAs($medewerker)->get(route('leverancier.edit', 2));
        $editResponse->assertStatus(200);
        $editResponse->assertSee('Wijzig Leveranciergegevens');
        $editResponse->assertSee('Sla op');

        // Stap 3: Wijzig Mobiel naar 06-39398825 en Straatnaam naar Den Dolderlaan
        $updateResponse = $this->actingAs($medewerker)->put(route('leverancier.update', 2), [
            'naam' => 'Astra Sweets',
            'contactpersoon' => 'Jasper del Monte',
            'leveranciernummer' => 'L1029284315',
            'mobiel' => '06-39398825',
            'straat' => 'Den Dolderlaan',
            'huisnummer' => '2',
            'postcode' => '1067RC',
            'stad' => 'Utrecht',
        ]);

        $updateResponse->assertStatus(200);
        $updateResponse->assertSee('De wijzigingen zijn doorgevoerd');
        $updateResponse->assertSee('3000');
        $updateResponse->assertSee(route('leverancier.details', 2));

        // Controleer dat de wijzigingen in de database zijn opgeslagen
        $this->assertDatabaseHas('Leverancier', [
            'Id' => 2,
            'Naam' => 'Astra Sweets',
            'Mobiel' => '06-39398825',
        ]);

        $this->assertDatabaseHas('Contact', [
            'Id' => 2,
            'Straat' => 'Den Dolderlaan',
        ]);
    }

    /**
     * User Story 01 — Scenario 02: Wijzigen van De Bron mislukt, toont technische foutmelding en behoudt originele data.
     */
    public function test_scenario_02_wijzigen_de_bron_fails_with_technical_error_and_keeps_original_data(): void
    {
        $this->seed();
        $medewerker = User::where('email', 'magazijnmedewerker@gmail.com')->first();

        // Stap 1: Open Leverancier Details van De Bron (Id = 5)
        $detailsResponse = $this->actingAs($medewerker)->get(route('leverancier.details', 5));
        $detailsResponse->assertStatus(200);
        $detailsResponse->assertSee('De Bron');
        $detailsResponse->assertSee('06-34291234');
        $detailsResponse->assertSee('Leon van Bonstraat');

        // Stap 2: Probeer Mobiel te wijzigen naar 06-39398825
        $updateResponse = $this->actingAs($medewerker)->put(route('leverancier.update', 5), [
            'naam' => 'De Bron',
            'contactpersoon' => 'Remco Veenstra',
            'leveranciernummer' => 'L1023857736',
            'mobiel' => '06-39398825',
            'straat' => 'Leon van Bonstraat',
            'huisnummer' => '213',
            'postcode' => '145XC',
            'stad' => 'Lunteren',
        ]);

        $updateResponse->assertStatus(200);
        $updateResponse->assertSee('Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens');
        $updateResponse->assertSee('3000');
        $updateResponse->assertSee(route('leverancier.details', 5));

        // Controleer dat De Bron NIET is gewijzigd in de database
        $this->assertDatabaseHas('Leverancier', [
            'Id' => 5,
            'Naam' => 'De Bron',
            'Mobiel' => '06-34291234',
        ]);
    }
}
