# Database Specificatie Tabellen — Jamin Magazijn & Producten System

## 1. Product
| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | | No | PK |
| Naam | VARCHAR | 100 | No | |
| Barcode | VARCHAR | 13 | No | |
| IsActief | BIT | 1 | No | Default 1 |
| Opmerking | VARCHAR | 250 | Yes | Default NULL |
| DatumAangemaakt | DATETIME | 6 | No | |
| DatumGewijzigd | DATETIME | 6 | No | |

## 2. Magazijn
| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | | No | PK |
| ProductId | TINYINT UNSIGNED | | No | FK(Product) |
| VerpakkingsEenheid | DECIMAL | 8,3 | No | kg |
| AantalAanwezig | INT UNSIGNED | | Yes | |
| IsActief | BIT | 1 | No | Default 1 |
| Opmerking | VARCHAR | 250 | Yes | Default NULL |
| DatumAangemaakt | DATETIME | 6 | No | |
| DatumGewijzigd | DATETIME | 6 | No | |

## 3. Allergeen
| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | | No | PK |
| Naam | VARCHAR | 100 | No | |
| Omschrijving | VARCHAR | 250 | No | |
| IsActief | BIT | 1 | No | Default 1 |
| Opmerking | VARCHAR | 250 | Yes | Default NULL |
| DatumAangemaakt | DATETIME | 6 | No | |
| DatumGewijzigd | DATETIME | 6 | No | |

## 4. ProductPerAllergeen
| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | | No | PK |
| ProductId | TINYINT UNSIGNED | | No | FK(Product) |
| AllergeenId | TINYINT UNSIGNED | | No | FK(Allergeen) |
| IsActief | BIT | 1 | No | Default 1 |
| Opmerking | VARCHAR | 250 | Yes | Default NULL |
| DatumAangemaakt | DATETIME | 6 | No | |
| DatumGewijzigd | DATETIME | 6 | No | |

## 5. Leverancier
| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | | No | PK |
| Naam | VARCHAR | 100 | No | |
| ContactPersoon | VARCHAR | 100 | No | |
| LeverancierNummer | VARCHAR | 20 | No | |
| Mobiel | VARCHAR | 15 | No | |
| IsActief | BIT | 1 | No | Default 1 |
| Opmerking | VARCHAR | 250 | Yes | Default NULL |
| DatumAangemaakt | DATETIME | 6 | No | |
| DatumGewijzigd | DATETIME | 6 | No | |

## 6. ProductPerLeverancier
| Kolom naam | Datatype | Lengte | Nullable | Opmerking |
| --- | --- | --- | --- | --- |
| Id | TINYINT UNSIGNED | | No | PK |
| LeverancierId | TINYINT UNSIGNED | | No | FK(Leverancier) |
| ProductId | TINYINT UNSIGNED | | No | FK(Product) |
| DatumLevering | DATE | | No | |
| Aantal | INT UNSIGNED | | No | |
| DatumEerstVolgendeLevering | DATE | | Yes | |
| IsActief | BIT | 1 | No | Default 1 |
| Opmerking | VARCHAR | 250 | Yes | Default NULL |
| DatumAangemaakt | DATETIME | 6 | No | |
| DatumGewijzigd | DATETIME | 6 | No | |
