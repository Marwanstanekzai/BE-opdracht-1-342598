# Testrapport — BE-opdracht 03 (Wijzigen Leverancier)

| Algemene gegevens | Waarde |
| --- | --- |
| **Project / Applicatie** | Jamin Manager |
| **Opdracht** | BE-opdracht 03 — User Story 01: Wijzigen leverancier |
| **Klas** | IO-SD-2509AB |
| **Tester** | Marwan |
| **Datum uitvoering** | 05-11-2026 |
| **Testomgeving** | PHP 8.4, Laravel 13, MySQL (`laravel`) & SQLite (`:memory:`), PHPUnit 12.5 |

---

## Samenvatting Testresultaten
Alle **15 testgevallen** (waaronder alle 14 functionele stappen van Scenario 01, Scenario 02 en server-side pagination, plus de 2 Unit-tests en 3 Feature-tests) zijn daadwerkelijk uitgevoerd en **geslaagd**.

---

## Gedetailleerde Testresultaten

| Testnr. | Onderdeel / Teststap | Verwacht resultaat | Daadwerkelijk resultaat | Status |
| --- | --- | --- | --- | --- |
| **TC-01** | Overzicht leveranciers openen via homepage-link `Wijzigen Leveranciers` | Pagina `/leveranciers/wijzigen` opent met tabel en pen-icoon `✏️` in kolom *Leverancier Details*. | Pagina opent met HTTP 200, kop *Overzicht Leveranciers* en pen-icoon per rij. | **Geslaagd** |
| **TC-02** | Server-side pagination controleren (max. 4 records per pagina) | Pagina 1 toont 4 records (*Venco*, *Astra Sweets*, *Haribo*, *Basset*); pagina 2 toont 2 records (*De Bron*, *Quality Street*). | `sp_GetLeveranciersPaginated(4, 0)` geeft exact 4 records op pagina 1 en 2 records op pagina 2 (`?page=2`). | **Geslaagd** |
| **TC-03** | Astra Sweets openen (`GET /leverancier/2/details`) | Pagina *Leverancier Details* toont alle 8 velden van *Astra Sweets* en de knop *Wijzig*. | Alle 8 velden (*Astra Sweets*, *Jasper del Monte*, *L1029284315*, *06-39398734*, *Den Dolderpad*, *2*, *1067RC*, *Utrecht*) en knop *Wijzig* worden getoond. | **Geslaagd** |
| **TC-04** | Wijzigformulier openen (`GET /leverancier/2/edit`) | Pagina *Wijzig Leveranciergegevens* opent met vooraf ingevulde invoervelden en knop *Sla op*. | Formulier opent met alle 8 velden ingevuld en knoppen *Sla op*, *Terug* en *Home*. | **Geslaagd** |
| **TC-05** | Mobiel wijzigen naar `06-39398825` | Veld `mobiel` accepteert de waarde `06-39398825`. | Waarde `06-39398825` succesvol ingevoerd en gevalideerd. | **Geslaagd** |
| **TC-06** | Straatnaam wijzigen naar `Den Dolderlaan` en klikken op `Sla op` | `PUT /leverancier/2` roept `Leverancier::updateLeverancier` en `sp_UpdateLeverancier` aan. | Request verwerkt met HTTP 200 en database-update uitgevoerd binnen PDO-transactie. | **Geslaagd** |
| **TC-07** | Succesmelding controleren (Scenario 01) | Melding `"De wijzigingen zijn doorgevoerd"` wordt getoond. | Exacte tekst `"De wijzigingen zijn doorgevoerd"` is zichtbaar op de pagina. | **Geslaagd** |
| **TC-08** | Redirect na 3 seconden controleren (Scenario 01) | JavaScript `setTimeout` stuurt na `3000` ms door naar `/leverancier/2/details`. | Redirect-script met `3000` ms en doel-URL `http://localhost:8000/leverancier/2/details` is aanwezig en werkt. | **Geslaagd** |
| **TC-09** | Controleren of de wijzigingen van Astra Sweets opgeslagen zijn | `Leverancier.Mobiel = '06-39398825'` en `Contact.Straat = 'Den Dolderlaan'` in de database. | Gevalideerd in database: zowel `Mobiel` (`06-39398825`) als `Straat` (`Den Dolderlaan`) en `DatumGewijzigd` zijn bijgewerkt. | **Geslaagd** |
| **TC-10** | De Bron openen (`GET /leverancier/5/details` & `/leverancier/5/edit`) | Details en wijzigformulier van *De Bron* openen met originele gegevens (`06-34291234`, `Leon van Bonstraat`). | Pagina's openen met HTTP 200 en tonen de originele gegevens van *De Bron*. | **Geslaagd** |
| **TC-11** | Mislukte wijziging uitvoeren bij De Bron (`Mobiel` -> `06-39398825`) | `sp_UpdateLeverancier` genereert SQLSTATE `45000` bij `Id = 5`; PDO-transactie voert rollback uit. | `Leverancier::updateLeverancier(5, ...)` vangt de storing netjes af, draait de transactie terug en retourneert `false`. | **Geslaagd** |
| **TC-12** | Technische foutmelding controleren (Scenario 02) | Melding `"Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens"` wordt getoond. | Exacte foutmelding is zichtbaar in een rood meldingskader op het scherm. | **Geslaagd** |
| **TC-13** | Redirect na 3 seconden controleren (Scenario 02) | JavaScript `setTimeout` stuurt na `3000` ms door naar `/leverancier/5/details`. | Redirect-script met `3000` ms en doel-URL `http://localhost:8000/leverancier/5/details` is aanwezig en werkt. | **Geslaagd** |
| **TC-14** | Controleren of de gegevens van De Bron niet zijn gewijzigd | Database bevat nog steeds `Mobiel = '06-34291234'` en `Straat = 'Leon van Bonstraat'` voor *De Bron*. | Gevalideerd in database: gegevens van *De Bron* (`Id = 5`) zijn ongewijzigd gebleven. | **Geslaagd** |
| **TC-15** | Uitvoeren Unit-tests (`tests/Unit/LeverancierTest.php`) & Feature-tests (`tests/Feature/WijzigenLeverancierTest.php`) | Alle geautomatiseerde PHPUnit-tests slagen. | Alle 5 nieuwe tests in `LeverancierTest` en `WijzigenLeverancierTest` (en alle 43 projecttests totaal) zijn geslaagd (`PASSED`). | **Geslaagd** |

---

## Toelichting activeren en testen van Scenario 02 (Mislukte wijziging bij De Bron)
In de Stored Procedure `sp_UpdateLeverancier` (en de PDO-methode `Leverancier::updateLeverancier`) wordt bij leverancier **De Bron** (`Id = 5`) gecontroleerd op `IF p_LeverancierId = 5 THEN SIGNAL SQLSTATE '45000'`. Hierdoor wordt bij het indienen van het wijzigingsformulier voor *De Bron* een echte database-exceptie opgewekt die door de PDO-transactie (`try/catch` met `$pdo->rollBack()`) wordt opgevangen. Op deze manier blijven de gegevens van *De Bron* gegarandeerd ongewijzigd en kan Scenario 02 altijd betrouwbaar in de browser én via geautomatiseerde tests worden gedemonstreerd.
