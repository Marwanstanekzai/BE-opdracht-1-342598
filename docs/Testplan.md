# Testplan — BE-opdracht 03 (Wijzigen Leverancier)

Zie ook [`docs/Testplan/Testplan.md`](Testplan/Testplan.md).

| Testnr. | Onderdeel / Scenario | Voorwaarde | Testactie / Stappen | Verwacht resultaat |
| --- | --- | --- | --- | --- |
| **TC-01** | Overzicht leveranciers openen | Ingelogd als `magazijnmedewerker@gmail.com` op `/dashboard`. | Klik op **Wijzigen Leveranciers**. | Scherm **Overzicht Leveranciers** (`/leveranciers/wijzigen`) opent met pen-iconen (`✏️`). |
| **TC-02** | Pagination controleren: maximaal 4 records | Op **Overzicht Leveranciers**. | Controleer pagina 1 en pagina 2 (`?page=2`). | Pagina 1 toont 4 records (*Venco*, *Astra Sweets*, *Haribo*, *Basset*); pagina 2 toont 2 records (*De Bron*, *Quality Street*). |
| **TC-03** | Astra Sweets openen | Op pagina 1 van **Overzicht Leveranciers**. | Klik op `✏️` bij **Astra Sweets**. | **Leverancier Details** (`/leverancier/2/details`) toont alle 8 velden van *Astra Sweets* en knop **Wijzig**. |
| **TC-04** | Wijzigformulier openen | Op **Leverancier Details** van *Astra Sweets*. | Klik op **Wijzig**. | **Wijzig Leveranciergegevens** (`/leverancier/2/edit`) opent met alle 8 invoervelden. |
| **TC-05** | Mobiel wijzigen | Op wijzigformulier van *Astra Sweets*. | Wijzig **Mobiel** naar `06-39398825`. | Veld **Mobiel** bevat `06-39398825`. |
| **TC-06** | Straatnaam wijzigen | Op wijzigformulier van *Astra Sweets*. | Wijzig **Straatnaam** naar `Den Dolderlaan` en klik op **Sla op**. | Formulier wordt verstuurd en verwerkt via PDO & Stored Procedure `sp_UpdateLeverancier`. |
| **TC-07** | Succesmelding controleren | Na klikken op **Sla op** bij *Astra Sweets*. | Controleer melding op het scherm. | Melding `"De wijzigingen zijn doorgevoerd"` is zichtbaar. |
| **TC-08** | Redirect na 3 seconden controleren | Succesmelding is zichtbaar. | Wacht 3 seconden (`3000` ms). | Automatische redirect naar **Leverancier Details** van *Astra Sweets* (`/leverancier/2/details`). |
| **TC-09** | Controleren of de wijzigingen opgeslagen zijn | Terug op **Leverancier Details** van *Astra Sweets*. | Controleer scherm en database. | Mobiel is `06-39398825` en Straatnaam is `Den Dolderlaan`. |
| **TC-10** | De Bron openen | Op pagina 2 van **Overzicht Leveranciers** (`?page=2`). | Klik op `✏️` bij **De Bron** en klik op **Wijzig**. | **Leverancier Details** (`/leverancier/5/details`) en daarna **Wijzig Leveranciergegevens** (`/leverancier/5/edit`) openen. |
| **TC-11** | Mislukte wijziging uitvoeren | Op wijzigformulier van *De Bron*. | Wijzig **Mobiel** naar `06-39398825` en klik op **Sla op**. | Stored Procedure / PDO-transactie weigert wijziging en voert rollback uit. |
| **TC-12** | Technische foutmelding controleren | Na klikken op **Sla op** bij *De Bron*. | Controleer foutmelding op het scherm. | Melding `"Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens"` is zichtbaar. |
| **TC-13** | Redirect na 3 seconden controleren | Foutmelding is zichtbaar bij *De Bron*. | Wacht 3 seconden (`3000` ms). | Automatische redirect naar **Leverancier Details** van *De Bron* (`/leverancier/5/details`). |
| **TC-14** | Controleren of de gegevens van De Bron niet zijn gewijzigd | Terug op **Leverancier Details** van *De Bron*. | Controleer scherm en database. | Mobiel is nog steeds `06-34291234` en Straatnaam is nog steeds `Leon van Bonstraat`. |
| **TC-15** | Unit-tests uitvoeren | PHPUnit testomgeving. | Voer `tests/Unit/LeverancierTest.php` uit. | Beide unit-tests slagen (`PASSED`). |
