# Class-Diagram — Jamin Manager (BE-opdracht 03)

Dit class-diagram is gebaseerd op de daadwerkelijke classes in de applicatie voor het beheren en wijzigen van leveranciers en gerelateerde entiteiten.

```mermaid
classDiagram
    class Controller {
        <<abstract>>
    }

    class LeverancierController {
        +index() View
        +producten(int id) View
        +wijzigenIndex() View
        +details(int id) View
        +edit(int id) View
        +update(Request request, int id) View
    }

    class LeveringController {
        +show(int id) View
        +create(int leverancierId, int productId) View
        +store(Request request, int leverancierId, int productId) View|RedirectResponse
    }

    class MagazijnController {
        +index() View
    }

    class AllergeenController {
        +show(int id) View
    }

    class Leverancier {
        #string table = "Leverancier"
        #string primaryKey = "Id"
        +bool timestamps = false
        +int Id
        +string Naam
        +string ContactPersoon
        +string LeverancierNummer
        +string Mobiel
        +int ContactId
        +bool IsActief
        +string Opmerking
        +string DatumAangemaakt
        +string DatumGewijzigd
        +contact() BelongsTo
        +producten() BelongsToMany
        +getLeveranciersOverzicht()$ array
        +getLeverancierById(int id)$ object|null
        +getGeleverdeProductenByLeverancierId(int id)$ array
        +getProductVoorLevering(int leverancierId, int productId)$ object|null
        +voegLeveringToe(int leverancierId, int productId, int aantal, string datumEerstvolgendeLevering)$ bool
        +getLeveranciersPaginated(int perPage, int page)$ LengthAwarePaginator
        +getLeverancierDetailsById(int id)$ object|null
        +getContactById(int contactId)$ object|null
        +updateLeverancier(int id, array data)$ bool
    }

    class Contact {
        #string table = "Contact"
        #string primaryKey = "Id"
        +bool timestamps = false
        +int Id
        +string Straat
        +string Huisnummer
        +string Postcode
        +string Stad
        +bool IsActief
        +string Opmerking
        +string DatumAangemaakt
        +string DatumGewijzigd
        +leverancier() HasOne
    }

    class Product {
        #string table = "Product"
        #string primaryKey = "Id"
        +bool timestamps = false
        +int Id
        +string Naam
        +string Barcode
        +bool IsActief
        +string Opmerking
        +string DatumAangemaakt
        +string DatumGewijzigd
        +magazijn() HasOne
        +allergenen() BelongsToMany
        +leveranciers() BelongsToMany
    }

    class Magazijn {
        #string table = "Magazijn"
        #string primaryKey = "Id"
        +bool timestamps = false
        +int Id
        +int ProductId
        +float VerpakkingsEenheid
        +int AantalAanwezig
        +bool IsActief
        +string Opmerking
        +string DatumAangemaakt
        +string DatumGewijzigd
        +product() BelongsTo
    }

    class Allergeen {
        #string table = "Allergeen"
        #string primaryKey = "Id"
        +bool timestamps = false
        +int Id
        +string Naam
        +string Omschrijving
        +bool IsActief
        +string Opmerking
        +string DatumAangemaakt
        +string DatumGewijzigd
        +producten() BelongsToMany
    }

    class ProductPerLeverancier {
        #string table = "ProductPerLeverancier"
        #string primaryKey = "Id"
        +bool timestamps = false
        +int Id
        +int LeverancierId
        +int ProductId
        +string DatumLevering
        +int Aantal
        +string DatumEerstVolgendeLevering
        +bool IsActief
        +string Opmerking
        +string DatumAangemaakt
        +string DatumGewijzigd
        +product() BelongsTo
        +leverancier() BelongsTo
    }

    class ProductPerAllergeen {
        #string table = "ProductPerAllergeen"
        #string primaryKey = "Id"
        +bool timestamps = false
        +int Id
        +int ProductId
        +int AllergeenId
        +bool IsActief
        +string Opmerking
        +string DatumAangemaakt
        +string DatumGewijzigd
        +product() BelongsTo
        +allergeen() BelongsTo
    }

    Controller <|-- LeverancierController
    Controller <|-- MagazijnController
    Controller <|-- AllergeenController

    LeverancierController ..> Leverancier : gebruikt PDO & Stored Procedures
    LeveringController ..> Leverancier : gebruikt PDO & Stored Procedures
    LeveringController ..> Product : gebruikt
    LeveringController ..> ProductPerLeverancier : gebruikt
    MagazijnController ..> Product : gebruikt
    AllergeenController ..> Product : gebruikt

    Leverancier "1" --> "0..1" Contact : ContactId
    Leverancier "1" --> "0..*" ProductPerLeverancier : LeverancierId
    Product "1" --> "0..*" ProductPerLeverancier : ProductId
    Product "1" --> "1" Magazijn : ProductId
    Product "1" --> "0..*" ProductPerAllergeen : ProductId
    Allergeen "1" --> "0..*" ProductPerAllergeen : AllergeenId
```

---

## Toelichting per Class

| Class | Namespace | Verantwoordelijkheid |
| --- | --- | --- |
| `LeverancierController` | `App\Http\Controllers` | Verwerkt HTTP-requests voor het leveranciersoverzicht, gepagineerd wijzigingsoverzicht (`wijzigenIndex`), leverancierdetails (`details`), wijzigingsformulier (`edit`) en opslaan van wijzigingen (`update`). |
| `Leverancier` | `App\Models` | Bevat de Eloquent-relaties naar `Contact` en `Product` én alle statische PDO-methodes die communiceren met de MySQL Stored Procedures (`sp_CountLeveranciers`, `sp_GetLeveranciersPaginated`, `sp_GetLeverancierDetailsById`, `sp_GetContactById`, `sp_UpdateLeverancier`). |
| `Contact` | `App\Models` | Model voor de tabel `Contact` met adresgegevens (`Straat`, `Huisnummer`, `Postcode`, `Stad`) gekoppeld aan `Leverancier`. |
| `Product`, `Magazijn`, `Allergeen`, `ProductPerAllergeen`, `ProductPerLeverancier` | `App\Models` | Modellen voor producten, voorraad, allergenen en leveringen per leverancier. |
