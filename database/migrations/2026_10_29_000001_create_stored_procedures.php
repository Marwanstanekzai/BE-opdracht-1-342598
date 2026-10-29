<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Only run for MySQL
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetLeveranciersOverzicht`;');
            DB::unprepared('
                CREATE PROCEDURE `sp_GetLeveranciersOverzicht`()
                BEGIN
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
                    ORDER BY AantalVerschillendeProducten DESC, l.Naam ASC;
                END
            ');

            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetLeverancierById`;');
            DB::unprepared('
                CREATE PROCEDURE `sp_GetLeverancierById`(
                    IN p_LeverancierId TINYINT UNSIGNED
                )
                BEGIN
                    SELECT 
                        l.Id,
                        l.Naam,
                        l.ContactPersoon,
                        l.LeverancierNummer,
                        l.Mobiel,
                        l.IsActief
                    FROM Leverancier l
                    WHERE l.Id = p_LeverancierId;
                END
            ');

            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetGeleverdeProductenByLeverancierId`;');
            DB::unprepared('
                CREATE PROCEDURE `sp_GetGeleverdeProductenByLeverancierId`(
                    IN p_LeverancierId TINYINT UNSIGNED
                )
                BEGIN
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
                    WHERE ppl.LeverancierId = p_LeverancierId
                    GROUP BY p.Id, p.Naam, p.IsActief, m.AantalAanwezig, m.VerpakkingsEenheid
                    ORDER BY m.AantalAanwezig DESC, p.Naam ASC;
                END
            ');

            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetProductVoorLevering`;');
            DB::unprepared('
                CREATE PROCEDURE `sp_GetProductVoorLevering`(
                    IN p_LeverancierId TINYINT UNSIGNED,
                    IN p_ProductId TINYINT UNSIGNED
                )
                BEGIN
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
                    INNER JOIN Product p ON p.Id = p_ProductId
                    LEFT JOIN ProductPerLeverancier ppl ON ppl.LeverancierId = l.Id AND ppl.ProductId = p.Id
                    WHERE l.Id = p_LeverancierId
                    LIMIT 1;
                END
            ');

            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_AddProductLevering`;');
            DB::unprepared('
                CREATE PROCEDURE `sp_AddProductLevering`(
                    IN p_LeverancierId TINYINT UNSIGNED,
                    IN p_ProductId TINYINT UNSIGNED,
                    IN p_Aantal INT UNSIGNED,
                    IN p_DatumEerstVolgendeLevering DATE
                )
                BEGIN
                    INSERT INTO ProductPerLeverancier (
                        LeverancierId,
                        ProductId,
                        DatumLevering,
                        Aantal,
                        DatumEerstVolgendeLevering,
                        IsActief,
                        Opmerking,
                        DatumAangemaakt,
                        DatumGewijzigd
                    ) VALUES (
                        p_LeverancierId,
                        p_ProductId,
                        CURDATE(),
                        p_Aantal,
                        p_DatumEerstVolgendeLevering,
                        1,
                        NULL,
                        NOW(6),
                        NOW(6)
                    );

                    UPDATE Magazijn 
                    SET AantalAanwezig = COALESCE(AantalAanwezig, 0) + p_Aantal,
                        DatumGewijzigd = NOW(6)
                    WHERE ProductId = p_ProductId;
                END
            ');
        }
    }

    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetLeveranciersOverzicht`;');
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetLeverancierById`;');
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetGeleverdeProductenByLeverancierId`;');
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetProductVoorLevering`;');
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_AddProductLevering`;');
        }
    }
};
