<?php

namespace Tests\Unit;

use App\Models\Contact;
use App\Models\Leverancier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LeverancierTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Unit test 1: Controleer of getLeverancierDetailsById en getLeveranciersPaginated
     * de juiste leveranciers- en contactgegevens ophalen en maximaal 4 records per pagina tonen.
     */
    public function test_get_leverancier_details_and_paginated_overview_returns_expected_data(): void
    {
        $this->seed();

        // Controleer server-side pagination (max 4 records op pagina 1 van 6 totaal)
        $pagina1 = Leverancier::getLeveranciersPaginated(4, 1);
        $this->assertCount(4, $pagina1->items());
        $this->assertEquals(6, $pagina1->total());

        $pagina2 = Leverancier::getLeveranciersPaginated(4, 2);
        $this->assertCount(2, $pagina2->items());

        // Controleer dat Astra Sweets (Id = 2) met juiste contactgegevens wordt opgehaald
        $astra = Leverancier::getLeverancierDetailsById(2);
        $this->assertNotNull($astra);
        $this->assertEquals('Astra Sweets', $astra->Naam);
        $this->assertEquals('Jasper del Monte', $astra->ContactPersoon);
        $this->assertEquals('L1029284315', $astra->LeverancierNummer);
        $this->assertEquals('06-39398734', $astra->Mobiel);
        $this->assertEquals('Den Dolderpad', $astra->Straat);
        $this->assertEquals('2', $astra->Huisnummer);
        $this->assertEquals('1067RC', $astra->Postcode);
        $this->assertEquals('Utrecht', $astra->Stad);
    }

    /**
     * Unit test 2: Controleer of updateLeverancier bij Astra Sweets (Scenario 01) true teruggeeft
     * en de gegevens opslaat, en bij De Bron (Scenario 02) false teruggeeft zonder gegevens te wijzigen.
     */
    public function test_update_leverancier_succeeds_for_astra_sweets_and_fails_for_de_bron(): void
    {
        $this->seed();

        // Scenario 01: Wijzigen van Astra Sweets (Id = 2) moet slagen
        $resultaatAstra = Leverancier::updateLeverancier(2, [
            'naam' => 'Astra Sweets',
            'contactpersoon' => 'Jasper del Monte',
            'leveranciernummer' => 'L1029284315',
            'mobiel' => '06-39398825',
            'straat' => 'Den Dolderlaan',
            'huisnummer' => '2',
            'postcode' => '1067RC',
            'stad' => 'Utrecht',
        ]);

        $this->assertTrue($resultaatAstra);

        $gewijzigdeAstra = Leverancier::getLeverancierDetailsById(2);
        $this->assertEquals('06-39398825', $gewijzigdeAstra->Mobiel);
        $this->assertEquals('Den Dolderlaan', $gewijzigdeAstra->Straat);

        // Scenario 02: Wijzigen van De Bron (Id = 5) moet mislukken en originele data behouden
        $resultaatDeBron = Leverancier::updateLeverancier(5, [
            'naam' => 'De Bron',
            'contactpersoon' => 'Remco Veenstra',
            'leveranciernummer' => 'L1023857736',
            'mobiel' => '06-39398825',
            'straat' => 'Leon van Bonstraat',
            'huisnummer' => '213',
            'postcode' => '145XC',
            'stad' => 'Lunteren',
        ]);

        $this->assertFalse($resultaatDeBron);

        $ongewijzigdeDeBron = Leverancier::getLeverancierDetailsById(5);
        $this->assertEquals('06-34291234', $ongewijzigdeDeBron->Mobiel);
        $this->assertEquals('Leon van Bonstraat', $ongewijzigdeDeBron->Straat);

        // Controleer ook Contact::find rechtstreeks
        $contactDeBron = Contact::find(5);
        $this->assertEquals('Leon van Bonstraat', $contactDeBron->Straat);
    }
}
