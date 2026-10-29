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
}
