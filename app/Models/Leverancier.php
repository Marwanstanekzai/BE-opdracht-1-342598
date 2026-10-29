<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Leverancier extends Model
{
    protected $table = 'Leverancier';

    protected $primaryKey = 'Id';

    protected $guarded = [];

    public $timestamps = false;

    public function producten()
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
            SELECT Id, Naam, ContactPersoon, LeverancierNummer, Mobiel, IsActief
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
}
