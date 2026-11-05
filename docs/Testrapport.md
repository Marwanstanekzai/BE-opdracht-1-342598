# Testrapport — BE-opdracht 03 (Wijzigen Leverancier)

Zie ook het volledige rapport in [`docs/Testrapport/Testrapport.md`](Testrapport/Testrapport.md).

| Testnr. | Onderdeel / Teststap | Daadwerkelijk resultaat | Status |
| --- | --- | --- | --- |
| **TC-01** | Overzicht leveranciers openen | Pagina `/leveranciers/wijzigen` toont tabel met pen-icoon `✏️`. | **Geslaagd** |
| **TC-02** | Pagination controleren: maximaal 4 records | Pagina 1 toont 4 records; pagina 2 (`?page=2`) toont 2 records. | **Geslaagd** |
| **TC-03** | Astra Sweets openen | `/leverancier/2/details` toont alle 8 velden en knop *Wijzig*. | **Geslaagd** |
| **TC-04** | Wijzigformulier openen | `/leverancier/2/edit` toont het ingevulde formulier. | **Geslaagd** |
| **TC-05** | Mobiel wijzigen (`06-39398825`) | Veld *Mobiel* geüpdatet naar `06-39398825`. | **Geslaagd** |
| **TC-06** | Straatnaam wijzigen (`Den Dolderlaan`) | Veld *Straatnaam* geüpdatet naar `Den Dolderlaan` en opgeslagen. | **Geslaagd** |
| **TC-07** | Succesmelding controleren | Melding `"De wijzigingen zijn doorgevoerd"` wordt getoond. | **Geslaagd** |
| **TC-08** | Redirect na 3 seconden controleren | Redirect na `3000` ms naar `/leverancier/2/details`. | **Geslaagd** |
| **TC-09** | Controleren of de wijzigingen opgeslagen zijn | `Leverancier` en `Contact` bevatten de nieuwe waarden voor *Astra Sweets*. | **Geslaagd** |
| **TC-10** | De Bron openen | `/leverancier/5/details` en `/leverancier/5/edit` openen voor *De Bron*. | **Geslaagd** |
| **TC-11** | Mislukte wijziging uitvoeren | Wijziging van *De Bron* (`Id = 5`) wordt geweigerd en teruggedraaid. | **Geslaagd** |
| **TC-12** | Technische foutmelding controleren | Melding `"Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens"` wordt getoond. | **Geslaagd** |
| **TC-13** | Redirect na 3 seconden controleren | Redirect na `3000` ms naar `/leverancier/5/details`. | **Geslaagd** |
| **TC-14** | Controleren of de gegevens van De Bron niet zijn gewijzigd | Mobiel (`06-34291234`) en Straat (`Leon van Bonstraat`) zijn ongewijzigd in de database. | **Geslaagd** |
| **TC-15** | Unit-tests en Feature-tests uitvoeren | Alle tests in `LeverancierTest` en `WijzigenLeverancierTest` zijn geslaagd (`PASSED`). | **Geslaagd** |
