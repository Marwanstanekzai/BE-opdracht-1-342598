<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class Leverancier extends Model
{
    protected $table = 'Leverancier';

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public $timestamps = false;

    /**
     * Relatie met de gekoppelde contactgegevens.
     */
    public function contact(): BelongsTo
    {
        return $this->belongsTo(
            Contact::class,
            'ContactId',
            'Id'
        );
    }

    /**
     * Relatie met geleverde producten.
     */
    public function producten(): BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'ProductPerLeverancier',
            'LeverancierId',
            'ProductId'
        );
    }

    /**
     * Haal alle leveranciers op met aantal verschillende geleverde producten via Stored Procedure & PDO.
     */
    public static function getLeveranciersOverzicht(): array
    {
        $pdo = DB::connection()->getPdo();

        if (DB::connection()->getDriverName() === 'mysql') {
            $stmt = $pdo->prepare('CALL sp_GetLeveranciersOverzicht()');
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $stmt->closeCursor();

            return $results;
        }

        $stmt = $pdo->prepare('
            SELECT 
                l.Id,
                l.Naam,
                l.ContactPersoon,
                l.LeverancierNummer,
                l.Mobiel,
                COUNT(DISTINCT ppl.ProductId) AS AantalVerschillendeProducten
            FROM Leverancier l
            LEFT JOIN ProductPerLeverancier ppl ON l.Id = ppl.LeverancierId
            GROUP BY l.Id, l.Naam, l.ContactPersoon, l.LeverancierNummer, l.Mobiel
            ORDER BY AantalVerschillendeProducten DESC, l.Naam ASC
        ');
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Haal specifieke leverancier op via Stored Procedure & PDO.
     */
    public static function getLeverancierById(int $id): ?object
    {
        $pdo = DB::connection()->getPdo();

        if (DB::connection()->getDriverName() === 'mysql') {
            $stmt = $pdo->prepare('CALL sp_GetLeverancierById(:id)');
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_OBJ) ?: null;
            $stmt->closeCursor();

            return $result;
        }

        $stmt = $pdo->prepare('
            SELECT Id, Naam, ContactPersoon, LeverancierNummer, Mobiel, ContactId, IsActief
            FROM Leverancier
            WHERE Id = :id
        ');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ) ?: null;
    }

    /**
     * Haal alle door de leverancier geleverde producten op via Stored Procedure & PDO.
     */
    public static function getGeleverdeProductenByLeverancierId(int $id): array
    {
        $pdo = DB::connection()->getPdo();

        if (DB::connection()->getDriverName() === 'mysql') {
            $stmt = $pdo->prepare('CALL sp_GetGeleverdeProductenByLeverancierId(:id)');
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $stmt->closeCursor();

            return $results;
        }

        $stmt = $pdo->prepare('
            SELECT 
                p.Id AS ProductId,
                p.Naam AS ProductNaam,
                p.IsActief AS ProductIsActief,
                m.AantalAanwezig,
                m.VerpakkingsEenheid,
                MAX(ppl.DatumLevering) AS LaatsteLevering
            FROM ProductPerLeverancier ppl
            INNER JOIN Product p ON ppl.ProductId = p.Id
            LEFT JOIN Magazijn m ON p.Id = m.ProductId
            WHERE ppl.LeverancierId = :id
            GROUP BY p.Id, p.Naam, p.IsActief, m.AantalAanwezig, m.VerpakkingsEenheid
            ORDER BY m.AantalAanwezig DESC, p.Naam ASC
        ');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Haal product- en leveranciergegevens op voor een levering via Stored Procedure & PDO.
     */
    public static function getProductVoorLevering(int $leverancierId, int $productId): ?object
    {
        $pdo = DB::connection()->getPdo();

        if (DB::connection()->getDriverName() === 'mysql') {
            $stmt = $pdo->prepare('CALL sp_GetProductVoorLevering(:levId, :prodId)');
            $stmt->bindValue(':levId', $leverancierId, \PDO::PARAM_INT);
            $stmt->bindValue(':prodId', $productId, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_OBJ) ?: null;
            $stmt->closeCursor();

            return $result;
        }

        $stmt = $pdo->prepare('
            SELECT 
                l.Id AS LeverancierId,
                l.Naam AS LeverancierNaam,
                l.ContactPersoon,
                l.LeverancierNummer,
                l.Mobiel,
                p.Id AS ProductId,
                p.Naam AS ProductNaam,
                p.IsActief AS ProductIsActief,
                ppl.IsActief AS LeveringIsActief
            FROM Leverancier l
            INNER JOIN Product p ON p.Id = :prodId
            LEFT JOIN ProductPerLeverancier ppl ON ppl.LeverancierId = l.Id AND ppl.ProductId = p.Id
            WHERE l.Id = :levId
            LIMIT 1
        ');
        $stmt->bindValue(':levId', $leverancierId, \PDO::PARAM_INT);
        $stmt->bindValue(':prodId', $productId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ) ?: null;
    }

    /**
     * Voeg een productlevering toe en verhoog de voorraad via Stored Procedure & PDO.
     */
    public static function voegLeveringToe(int $leverancierId, int $productId, int $aantal, ?string $datumEerstvolgendeLevering): bool
    {
        $pdo = DB::connection()->getPdo();

        if (DB::connection()->getDriverName() === 'mysql') {
            $stmt = $pdo->prepare('CALL sp_AddProductLevering(:levId, :prodId, :aantal, :datum)');
            $stmt->bindValue(':levId', $leverancierId, \PDO::PARAM_INT);
            $stmt->bindValue(':prodId', $productId, \PDO::PARAM_INT);
            $stmt->bindValue(':aantal', $aantal, \PDO::PARAM_INT);
            $stmt->bindValue(':datum', $datumEerstvolgendeLevering);
            $stmt->execute();
            $stmt->closeCursor();

            return true;
        }

        // SQLite fallback voor unittests
        $today = date('Y-m-d');
        $now = date('Y-m-d H:i:s');

        $stmt1 = $pdo->prepare('
            INSERT INTO ProductPerLeverancier (
                LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering, IsActief, Opmerking, DatumAangemaakt, DatumGewijzigd
            ) VALUES (
                :levId, :prodId, :datumLevering, :aantal, :datumEerstVolgende, 1, NULL, :now1, :now2
            )
        ');
        $stmt1->bindValue(':levId', $leverancierId, \PDO::PARAM_INT);
        $stmt1->bindValue(':prodId', $productId, \PDO::PARAM_INT);
        $stmt1->bindValue(':datumLevering', $today);
        $stmt1->bindValue(':aantal', $aantal, \PDO::PARAM_INT);
        $stmt1->bindValue(':datumEerstVolgende', $datumEerstvolgendeLevering);
        $stmt1->bindValue(':now1', $now);
        $stmt1->bindValue(':now2', $now);
        $stmt1->execute();

        $stmt2 = $pdo->prepare('
            UPDATE Magazijn
            SET AantalAanwezig = COALESCE(AantalAanwezig, 0) + :aantal,
                DatumGewijzigd = :now
            WHERE ProductId = :prodId
        ');
        $stmt2->bindValue(':aantal', $aantal, \PDO::PARAM_INT);
        $stmt2->bindValue(':now', $now);
        $stmt2->bindValue(':prodId', $productId, \PDO::PARAM_INT);
        $stmt2->execute();

        return true;
    }

    /**
     * BE-opdracht 03: Haal leveranciers gepagineerd op (server-side pagination met max 4 records) via Stored Procedure & PDO.
     */
    public static function getLeveranciersPaginated(int $perPage = 4, ?int $page = null): LengthAwarePaginator
    {
        $currentPage = $page ?? LengthAwarePaginator::resolveCurrentPage();
        $currentPage = max(1, $currentPage);
        $offset = ($currentPage - 1) * $perPage;

        $pdo = DB::connection()->getPdo();

        if (DB::connection()->getDriverName() === 'mysql') {
            $countStmt = $pdo->prepare('CALL sp_CountLeveranciers()');
            $countStmt->execute();
            $totalRow = $countStmt->fetch(\PDO::FETCH_OBJ);
            $countStmt->closeCursor();
            $total = $totalRow ? (int) $totalRow->Totaal : 0;

            $stmt = $pdo->prepare('CALL sp_GetLeveranciersPaginated(:limit, :offset)');
            $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(\PDO::FETCH_OBJ);
            $stmt->closeCursor();
        } else {
            $countStmt = $pdo->prepare('SELECT COUNT(*) AS Totaal FROM Leverancier');
            $countStmt->execute();
            $totalRow = $countStmt->fetch(\PDO::FETCH_OBJ);
            $total = $totalRow ? (int) $totalRow->Totaal : 0;

            $stmt = $pdo->prepare('
                SELECT Id, Naam, ContactPersoon, LeverancierNummer, Mobiel, ContactId
                FROM Leverancier
                ORDER BY Id ASC
                LIMIT :limit OFFSET :offset
            ');
            $stmt->bindValue(':limit', $perPage, \PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, \PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(\PDO::FETCH_OBJ);
        }

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]
        );
    }

    /**
     * BE-opdracht 03: Haal leverancier- én contactgegevens op via Stored Procedure & PDO.
     */
    public static function getLeverancierDetailsById(int $id): ?object
    {
        $pdo = DB::connection()->getPdo();

        if (DB::connection()->getDriverName() === 'mysql') {
            $stmt = $pdo->prepare('CALL sp_GetLeverancierDetailsById(:id)');
            $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_OBJ) ?: null;
            $stmt->closeCursor();

            return $result;
        }

        $stmt = $pdo->prepare('
            SELECT 
                l.Id,
                l.Naam,
                l.ContactPersoon,
                l.LeverancierNummer,
                l.Mobiel,
                l.ContactId,
                l.IsActief AS LeverancierIsActief,
                c.Straat,
                c.Huisnummer,
                c.Postcode,
                c.Stad,
                c.IsActief AS ContactIsActief
            FROM Leverancier l
            LEFT JOIN Contact c ON l.ContactId = c.Id
            WHERE l.Id = :id
        ');
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ) ?: null;
    }

    /**
     * BE-opdracht 03: Haal contactgegevens op via Stored Procedure & PDO.
     */
    public static function getContactById(int $contactId): ?object
    {
        $pdo = DB::connection()->getPdo();

        if (DB::connection()->getDriverName() === 'mysql') {
            $stmt = $pdo->prepare('CALL sp_GetContactById(:id)');
            $stmt->bindValue(':id', $contactId, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_OBJ) ?: null;
            $stmt->closeCursor();

            return $result;
        }

        $stmt = $pdo->prepare('
            SELECT Id, Straat, Huisnummer, Postcode, Stad, IsActief
            FROM Contact
            WHERE Id = :id
        ');
        $stmt->bindValue(':id', $contactId, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_OBJ) ?: null;
    }

    /**
     * BE-opdracht 03: Wijzig leveranciergegevens en bijbehorende contactgegevens via Stored Procedure & PDO.
     *
     * Scenario 01: Wijziging lukt (bijv. Astra Sweets) -> retourneert true.
     * Scenario 02: Wijziging mislukt bij De Bron (Id = 5) -> transactie wordt teruggedraaid en retourneert false.
     *
     * @param  array{naam: string, contactpersoon: string, leveranciernummer: string, mobiel: string, straat: string, huisnummer: string, postcode: string, stad: string}  $data
     */
    public static function updateLeverancier(int $id, array $data): bool
    {
        $pdo = DB::connection()->getPdo();
        $startedTransaction = false;

        try {
            if (! $pdo->inTransaction()) {
                $pdo->beginTransaction();
                $startedTransaction = true;
            }

            if (DB::connection()->getDriverName() === 'mysql') {
                $stmt = $pdo->prepare('CALL sp_UpdateLeverancier(:id, :naam, :contactpersoon, :leveranciernummer, :mobiel, :straat, :huisnummer, :postcode, :stad)');
                $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
                $stmt->bindValue(':naam', $data['naam']);
                $stmt->bindValue(':contactpersoon', $data['contactpersoon']);
                $stmt->bindValue(':leveranciernummer', $data['leveranciernummer']);
                $stmt->bindValue(':mobiel', $data['mobiel']);
                $stmt->bindValue(':straat', $data['straat']);
                $stmt->bindValue(':huisnummer', $data['huisnummer']);
                $stmt->bindValue(':postcode', $data['postcode']);
                $stmt->bindValue(':stad', $data['stad']);
                $stmt->execute();
                $stmt->closeCursor();
            } else {
                // Scenario 02: Bij leverancier De Bron (Id = 5) treedt een technische storing op
                if ($id === 5) {
                    throw new \PDOException('Technische storing bij het wijzigen van leverancier De Bron');
                }

                $now = date('Y-m-d H:i:s');

                $findStmt = $pdo->prepare('SELECT ContactId FROM Leverancier WHERE Id = :id');
                $findStmt->bindValue(':id', $id, \PDO::PARAM_INT);
                $findStmt->execute();
                $row = $findStmt->fetch(\PDO::FETCH_OBJ);

                if (! $row) {
                    throw new \PDOException('Leverancier niet gevonden');
                }

                $updateLev = $pdo->prepare('
                    UPDATE Leverancier
                    SET Naam = :naam,
                        ContactPersoon = :contactpersoon,
                        LeverancierNummer = :leveranciernummer,
                        Mobiel = :mobiel,
                        DatumGewijzigd = :now
                    WHERE Id = :id
                ');
                $updateLev->bindValue(':naam', $data['naam']);
                $updateLev->bindValue(':contactpersoon', $data['contactpersoon']);
                $updateLev->bindValue(':leveranciernummer', $data['leveranciernummer']);
                $updateLev->bindValue(':mobiel', $data['mobiel']);
                $updateLev->bindValue(':now', $now);
                $updateLev->bindValue(':id', $id, \PDO::PARAM_INT);
                $updateLev->execute();

                if ($row->ContactId !== null) {
                    $updateContact = $pdo->prepare('
                        UPDATE Contact
                        SET Straat = :straat,
                            Huisnummer = :huisnummer,
                            Postcode = :postcode,
                            Stad = :stad,
                            DatumGewijzigd = :now
                        WHERE Id = :contactId
                    ');
                    $updateContact->bindValue(':straat', $data['straat']);
                    $updateContact->bindValue(':huisnummer', $data['huisnummer']);
                    $updateContact->bindValue(':postcode', $data['postcode']);
                    $updateContact->bindValue(':stad', $data['stad']);
                    $updateContact->bindValue(':now', $now);
                    $updateContact->bindValue(':contactId', (int) $row->ContactId, \PDO::PARAM_INT);
                    $updateContact->execute();
                }
            }

            if ($startedTransaction && $pdo->inTransaction()) {
                $pdo->commit();
            }

            return true;
        } catch (\Throwable) {
            if ($startedTransaction && $pdo->inTransaction()) {
                $pdo->rollBack();
            }

            return false;
        }
    }
}
