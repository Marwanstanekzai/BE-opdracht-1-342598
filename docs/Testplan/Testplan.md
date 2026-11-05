# Testplan — BE-opdracht 03 (Wijzigen Leverancier)

| Algemene gegevens | Waarde |
| --- | --- |
| **Project / Applicatie** | Jamin Manager |
| **Opdracht** | BE-opdracht 03 — User Story 01: Wijzigen leverancier |
| **Klas** | IO-SD-2509AB |
| **Auteur** | Marwan |
| **Datum** | 05-11-2026 |

---

## Doel van het Testplan
Het controleren en valideren van **User Story 01 (Wijzigen leverancier)** inclusief:
- Server-side pagination met maximaal 4 leveranciers per pagina op het scherm *Overzicht Leveranciers*.
- **Scenario 01**: Het succesvol wijzigen van leveranciergegevens (*Astra Sweets*) met de melding `"De wijzigingen zijn doorgevoerd"` en automatische redirect na 3 seconden naar *Leverancier Details*.
- **Scenario 02**: Het mislukken van een wijziging (*De Bron*) met de melding `"Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens"`, automatische redirect na 3 seconden en behoud van de oorspronkelijke gegevens in de database.

---

## Testgevallen (Testcases)

| Testnr. | Onderdeel / Scenario | Voorwaarde | Testactie / Stappen | Verwacht resultaat |
| --- | --- | --- | --- | --- |
| **TC-01** | Overzicht leveranciers openen | Ingelogd als `magazijnmedewerker@gmail.com` op het dashboard (`/dashboard`). | Klik op de link **Wijzigen Leveranciers** op de homepage. | De pagina **Overzicht Leveranciers** (`/leveranciers/wijzigen`) opent met de kolommen *Naam*, *Contactpersoon*, *Leveranciernummer*, *Mobiel* en *Leverancier Details* (pen-icoon `✏️`). |
| **TC-02** | Server-side pagination controleren (max. 4 records) | Gebruiker bevindt zich op **Overzicht Leveranciers** (`/leveranciers/wijzigen`). | Controleer het aantal getoonde rijen op pagina 1 en klik op pagina 2 (`?page=2`). | Pagina 1 toont exact 4 leveranciers (*Venco*, *Astra Sweets*, *Haribo*, *Basset*). Pagina 2 toont de overige 2 leveranciers (*De Bron*, *Quality Street*). |
| **TC-03** | Astra Sweets openen (Scenario 01) | Gebruiker bevindt zich op pagina 1 van **Overzicht Leveranciers**. | Klik op het pen-icoon (`✏️`) achter **Astra Sweets**. | De pagina **Leverancier Details** (`/leverancier/2/details`) opent met: Naam *Astra Sweets*, Contactpersoon *Jasper del Monte*, Leveranciernummer *L1029284315*, Mobiel *06-39398734*, Straatnaam *Den Dolderpad*, Huisnummer *2*, Postcode *1067RC*, Stad *Utrecht* en knop **Wijzig**. |
| **TC-04** | Wijzigformulier openen (Scenario 01) | Gebruiker bevindt zich op **Leverancier Details** van *Astra Sweets*. | Klik op de knop **Wijzig**. | De pagina **Wijzig Leveranciergegevens** (`/leverancier/2/edit`) opent met een formulier waarin alle 8 velden vooraf zijn ingevuld en de knoppen **Sla op**, **Terug** en **Home** zichtbaar zijn. |
| **TC-05** | Mobiel wijzigen (Scenario 01) | Gebruiker bevindt zich op **Wijzig Leveranciergegevens** van *Astra Sweets*. | Verander de waarde van het veld **Mobiel** van `06-39398734` naar `06-39398825`. | Het invoerveld **Mobiel** bevat de nieuwe waarde `06-39398825`. |
| **TC-06** | Straatnaam wijzigen en opslaan (Scenario 01) | Gebruiker heeft **Mobiel** aangepast op het formulier van *Astra Sweets*. | Verander de waarde van het veld **Straatnaam** van `Den Dolderpad` naar `Den Dolderlaan` en klik op de knop **Sla op**. | Het formulier wordt verstuurd via `PUT /leverancier/2` en verwerkt door `Leverancier::updateLeverancier` en Stored Procedure `sp_UpdateLeverancier`. |
| **TC-07** | Succesmelding controleren (Scenario 01) | Formulier van *Astra Sweets* is zojuist opgeslagen. | Controleer de melding op het scherm. | De exacte melding `"De wijzigingen zijn doorgevoerd"` wordt duidelijk op het scherm getoond. |
| **TC-08** | Redirect na 3 seconden controleren (Scenario 01) | Succesmelding is zichtbaar na het opslaan van *Astra Sweets*. | Wacht 3 seconden (`3000` ms). | De browser stuurt de gebruiker na 3 seconden automatisch terug naar de pagina **Leverancier Details** van *Astra Sweets* (`/leverancier/2/details`). |
| **TC-09** | Controleren of de wijzigingen opgeslagen zijn (Scenario 01) | Gebruiker is terug op **Leverancier Details** van *Astra Sweets*. | Controleer de gegevens op het scherm en in de database (`Leverancier` en `Contact`). | Op **Leverancier Details** en in de database staat bij *Astra Sweets* nu Mobiel `06-39398825` en Straatnaam `Den Dolderlaan`. |
| **TC-10** | De Bron openen (Scenario 02) | Gebruiker opent pagina 2 van **Overzicht Leveranciers** (`/leveranciers/wijzigen?page=2`). | Klik op het pen-icoon (`✏️`) achter **De Bron** en klik daarna op **Wijzig**. | De pagina **Leverancier Details** (`/leverancier/5/details`) toont *De Bron* (`06-34291234`, `Leon van Bonstraat 213`, `145XC Lunteren`). Na klikken op **Wijzig** opent **Wijzig Leveranciergegevens** (`/leverancier/5/edit`). |
| **TC-11** | Mislukte wijziging uitvoeren (Scenario 02) | Gebruiker bevindt zich op **Wijzig Leveranciergegevens** van *De Bron* (`Id = 5`). | Verander het veld **Mobiel** van `06-34291234` naar `06-39398825` en klik op **Sla op**. | De Stored Procedure `sp_UpdateLeverancier` / PDO-transactie detecteert de technische storing bij *De Bron* (`Id = 5`) en draait de transactie terug (`ROLLBACK`). |
| **TC-12** | Technische foutmelding controleren (Scenario 02) | Formulier van *De Bron* is zojuist verstuurd. | Controleer de foutmelding op het scherm. | De exacte melding `"Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens"` wordt getoond. |
| **TC-13** | Redirect na 3 seconden controleren (Scenario 02) | Technische foutmelding is zichtbaar bij *De Bron*. | Wacht 3 seconden (`3000` ms). | De browser stuurt de gebruiker na 3 seconden automatisch terug naar **Leverancier Details** van *De Bron* (`/leverancier/5/details`). |
| **TC-14** | Controleren of de gegevens van De Bron niet zijn gewijzigd (Scenario 02) | Gebruiker is terug op **Leverancier Details** van *De Bron*. | Controleer de gegevens op het scherm en in de database (`Leverancier` en `Contact`). | De gegevens van *De Bron* zijn ongewijzigd gebleven: Mobiel is nog steeds `06-34291234` en Straatnaam is nog steeds `Leon van Bonstraat`. |
| **TC-15** | Unit-tests uitvoeren (`LeverancierTest`) | Testdatabase (SQLite `:memory:`) beschikbaar via PHPUnit. | Voer `php artisan test --compact tests/Unit/LeverancierTest.php` uit. | Beide unit-tests (`test_get_leverancier_details_and_paginated_overview_returns_expected_data` en `test_update_leverancier_succeeds_for_astra_sweets_and_fails_for_de_bron`) slagen zonder fouten. |
