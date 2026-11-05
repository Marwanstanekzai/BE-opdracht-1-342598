# Database Specificatie Tabellen — Jamin Manager (BE-opdracht 03)

Overzicht van alle **7 tabellen** in de database `laravel` met kolomnamen, datatypen, veldlengtes, nullable-eigenschappen, primaire en vreemde sleutels en systeemvelden.

---

## 1. Tabel: `Contact`

| Kolomnaam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| `Id` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Primary Key (`PK`)**, `AUTO_INCREMENT` |
| `Straat` | `VARCHAR` | `100` | Nee (`NOT NULL`) | Straatnaam van de leverancier |
| `Huisnummer` | `VARCHAR` | `10` | Nee (`NOT NULL`) | Huisnummer (bijv. `34`, `257`) |
| `Postcode` | `VARCHAR` | `10` | Nee (`NOT NULL`) | Postcode (bijv. `1067RC`) |
| `Stad` | `VARCHAR` | `100` | Nee (`NOT NULL`) | Vestigingsplaats / stad |
| `IsActief` | `BIT` | `1` | Nee (`NOT NULL`) | Systeemveld, `DEFAULT b'1'` |
| `Opmerking` | `VARCHAR` | `250` | Ja (`NULL`) | Systeemveld, `DEFAULT NULL` |
| `DatumAangemaakt` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |
| `DatumGewijzigd` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |

---

## 2. Tabel: `Leverancier`

| Kolomnaam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| `Id` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Primary Key (`PK`)**, `AUTO_INCREMENT` |
| `Naam` | `VARCHAR` | `100` | Nee (`NOT NULL`) | Naam van de leverancier (incl. `Quality Street`) |
| `ContactPersoon` | `VARCHAR` | `100` | Nee (`NOT NULL`) | Naam van de contactpersoon |
| `LeverancierNummer` | `VARCHAR` | `20` | Nee (`NOT NULL`) | Uniek leveranciernummer (bijv. `L1029284315`) |
| `Mobiel` | `VARCHAR` | `15` | Nee (`NOT NULL`) | Mobiel telefoonnummer (bijv. `06-39398734`) |
| `ContactId` | `TINYINT UNSIGNED` | - | Ja (`NULL`) | **Foreign Key (`FK`)** verwijst naar `Contact(Id)` |
| `IsActief` | `BIT` | `1` | Nee (`NOT NULL`) | Systeemveld, `DEFAULT b'1'` |
| `Opmerking` | `VARCHAR` | `250` | Ja (`NULL`) | Systeemveld, `DEFAULT NULL` |
| `DatumAangemaakt` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |
| `DatumGewijzigd` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |

---

## 3. Tabel: `Product`

| Kolomnaam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| `Id` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Primary Key (`PK`)**, `AUTO_INCREMENT` |
| `Naam` | `VARCHAR` | `100` | Nee (`NOT NULL`) | Naam van het product |
| `Barcode` | `VARCHAR` | `13` | Nee (`NOT NULL`) | EAN-13 barcode |
| `IsActief` | `BIT` | `1` | Nee (`NOT NULL`) | Systeemveld, `DEFAULT b'1'` (`0` voor Winegums) |
| `Opmerking` | `VARCHAR` | `250` | Ja (`NULL`) | Systeemveld, `DEFAULT NULL` |
| `DatumAangemaakt` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |
| `DatumGewijzigd` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |

---

## 4. Tabel: `Magazijn`

| Kolomnaam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| `Id` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Primary Key (`PK`)**, `AUTO_INCREMENT` |
| `ProductId` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Foreign Key (`FK`)** verwijst naar `Product(Id)` |
| `VerpakkingsEenheid` | `DECIMAL` | `8,3` | Nee (`NOT NULL`) | Verpakkingseenheid in kilogram (bijv. `2,5`) |
| `AantalAanwezig` | `INT UNSIGNED` | - | Ja (`NULL`) | Voorraad in magazijn (`NULL` bij ProductId `10`) |
| `IsActief` | `BIT` | `1` | Nee (`NOT NULL`) | Systeemveld, `DEFAULT b'1'` |
| `Opmerking` | `VARCHAR` | `250` | Ja (`NULL`) | Systeemveld, `DEFAULT NULL` |
| `DatumAangemaakt` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |
| `DatumGewijzigd` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |

---

## 5. Tabel: `Allergeen`

| Kolomnaam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| `Id` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Primary Key (`PK`)**, `AUTO_INCREMENT` |
| `Naam` | `VARCHAR` | `100` | Nee (`NOT NULL`) | Naam van het allergeen |
| `Omschrijving` | `VARCHAR` | `250` | Nee (`NOT NULL`) | Omschrijving van het allergeen |
| `IsActief` | `BIT` | `1` | Nee (`NOT NULL`) | Systeemveld, `DEFAULT b'1'` |
| `Opmerking` | `VARCHAR` | `250` | Ja (`NULL`) | Systeemveld, `DEFAULT NULL` |
| `DatumAangemaakt` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |
| `DatumGewijzigd` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |

---

## 6. Tabel: `ProductPerAllergeen`

| Kolomnaam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| `Id` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Primary Key (`PK`)**, `AUTO_INCREMENT` |
| `ProductId` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Foreign Key (`FK`)** verwijst naar `Product(Id)` |
| `AllergeenId` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Foreign Key (`FK`)** verwijst naar `Allergeen(Id)` |
| `IsActief` | `BIT` | `1` | Nee (`NOT NULL`) | Systeemveld, `DEFAULT b'1'` |
| `Opmerking` | `VARCHAR` | `250` | Ja (`NULL`) | Systeemveld, `DEFAULT NULL` |
| `DatumAangemaakt` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |
| `DatumGewijzigd` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |

---

## 7. Tabel: `ProductPerLeverancier`

| Kolomnaam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| `Id` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Primary Key (`PK`)**, `AUTO_INCREMENT` (1 t/m 17; dubbele Id 14 uit opdracht opgelost door doornummering naar 15, 16, 17) |
| `LeverancierId` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Foreign Key (`FK`)** verwijst naar `Leverancier(Id)` |
| `ProductId` | `TINYINT UNSIGNED` | - | Nee (`NOT NULL`) | **Foreign Key (`FK`)** verwijst naar `Product(Id)` |
| `DatumLevering` | `DATE` | - | Nee (`NOT NULL`) | Datum waarop de levering plaatsvond |
| `Aantal` | `INT UNSIGNED` | - | Nee (`NOT NULL`) | Aantal geleverde eenheden |
| `DatumEerstVolgendeLevering` | `DATE` | - | Ja (`NULL`) | Verwachte eerstvolgende leveringsdatum (`NULL` toegestaan) |
| `IsActief` | `BIT` | `1` | Nee (`NOT NULL`) | Systeemveld, `DEFAULT b'1'` |
| `Opmerking` | `VARCHAR` | `250` | Ja (`NULL`) | Systeemveld, `DEFAULT NULL` |
| `DatumAangemaakt` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |
| `DatumGewijzigd` | `DATETIME` | `6` | Nee (`NOT NULL`) | Systeemveld (`SYSDATE(6)`) |

---

## 8. Overzicht Stored Procedures (`database/stored_procedures.sql`)

| Stored Procedure | Opdracht | Doel |
| --- | --- | --- |
| `sp_GetLeveranciersOverzicht` | BE-opdracht 02 | Haalt leveranciers op met `COUNT(DISTINCT ppl.ProductId)` aflopend gesorteerd. |
| `sp_GetLeverancierById` | BE-opdracht 02 | Haalt één leverancier op basis van `Id`. |
| `sp_GetGeleverdeProductenByLeverancierId` | BE-opdracht 02 | Haalt geleverde producten van een leverancier op. |
| `sp_GetProductVoorLevering` | BE-opdracht 02 | Haalt product- en leverancierdata op voor een nieuwe levering. |
| `sp_AddProductLevering` | BE-opdracht 02 | Voegt een levering toe en verhoogt de magazijnvoorraad. |
| `sp_CountLeveranciers` | BE-opdracht 03 | Telt het totaal aantal leveranciers voor server-side pagination. |
| `sp_GetLeveranciersPaginated` | BE-opdracht 03 | Haalt een pagina leveranciers op via `LIMIT` en `OFFSET` (max 4 records per pagina). |
| `sp_GetLeverancierDetailsById` | BE-opdracht 03 | Haalt leverancier- én gekoppelde contactgegevens op via `LEFT JOIN Contact`. |
| `sp_GetContactById` | BE-opdracht 03 | Haalt contactgegevens op basis van `ContactId`. |
| `sp_UpdateLeverancier` | BE-opdracht 03 | Wijzigt `Leverancier` en `Contact` en werkt `DatumGewijzigd` bij; genereert een SQLSTATE `45000` technische storing bij `De Bron` (`Id = 5`). |
