# Video Opnamescript — BE-opdracht 03 (Wijzigen Leverancier)

Plaats het opgenomen videobestand (bijv. `be_opdracht_03.mp4`) in deze map (`vids/`).

## Eisen aan de video
- **Opnametool**: Gebruik **Windows-toets + Shift + S** (schermopname) of **Windows-toets + G** (Xbox Game Bar).
- **Maximale duur**: **Maximaal 60 seconden**.
- **Belangrijk**: Film **alleen de browser en phpMyAdmin**, laat **geen code** zien!

---

## Stappenplan voor de opname (ca. 45–55 seconden)

### 1. Inloggen & Overzicht Leveranciers met Pagination (0:00 – 0:10)
1. Start de opname op de Jamin Manager homepage (`http://localhost:8000/dashboard`), ingelogd als `magazijnmedewerker@gmail.com` (wachtwoord: `password`).
2. Klik op de link **Wijzigen Leveranciers**.
3. Laat kort zien dat pagina 1 maximaal **4 leveranciers** toont (*Venco*, *Astra Sweets*, *Haribo*, *Basset*) en dat onderaan paginaknoppen staan.

### 2. Scenario 01 — Astra Sweets succesvol wijzigen (0:10 – 0:28)
1. Klik op pagina 1 op het pen-icoon (`✏️`) bij **Astra Sweets**.
2. Je ziet **Leverancier Details** van *Astra Sweets*. Klik op de knop **Wijzig**.
3. Verander het veld **Mobiel** naar `06-39398825`.
4. Verander het veld **Straatnaam** naar `Den Dolderlaan`.
5. Klik op **Sla op**.
6. Laat de groene melding zien: *"De wijzigingen zijn doorgevoerd"*.
7. Wacht 3 seconden tot de pagina automatisch terugkeert naar **Leverancier Details** van *Astra Sweets* en wijs kort de gewijzigde waarden (`06-39398825` en `Den Dolderlaan`) aan.

### 3. Scenario 02 — De Bron wijzigen mislukt (0:28 – 0:45)
1. Klik op **Terug** en ga in de paginering onderaan naar **pagina 2**.
2. Klik op het pen-icoon (`✏️`) bij **De Bron**.
3. Klik op **Wijzig**.
4. Verander het veld **Mobiel** naar `06-39398825` en klik op **Sla op**.
5. Laat de rode foutmelding zien: *"Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens"*.
6. Wacht 3 seconden tot de pagina automatisch terugkeert naar **Leverancier Details** van *De Bron* en laat zien dat het mobiele nummer nog steeds `06-34291234` is.

### 4. Database, relaties en data tonen in phpMyAdmin (0:45 – 0:58)
1. Schakel naar het tabblad van **phpMyAdmin** (database `laravel`).
2. Toon kort het overzicht met de **7 tabellen** (`Allergeen`, `Contact`, `Leverancier`, `Magazijn`, `Product`, `ProductPerAllergeen`, `ProductPerLeverancier`) en de **Stored Procedures**.
3. Open kort de tabel `Leverancier` en `Contact` (en/of Designer voor de relaties) zodat zichtbaar is dat *Astra Sweets* is bijgewerkt en *De Bron* ongewijzigd is gebleven.
4. Stop de opname en sla het bestand op in de map `vids/`.
