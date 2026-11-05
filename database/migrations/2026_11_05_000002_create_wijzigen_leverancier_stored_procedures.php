<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Maak de Stored Procedures aan voor BE-opdracht 03 (Wijzigen Leverancier).
     */
    public function up(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_CountLeveranciers`;');
            DB::unprepared('
                CREATE PROCEDURE `sp_CountLeveranciers`()
                BEGIN
                    SELECT COUNT(*) AS Totaal FROM Leverancier;
                END
            ');

            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetLeveranciersPaginated`;');
            DB::unprepared('
                CREATE PROCEDURE `sp_GetLeveranciersPaginated`(
                    IN p_Limit INT,
                    IN p_Offset INT
                )
                BEGIN
                    SELECT 
                        l.Id,
                        l.Naam,
                        l.ContactPersoon,
                        l.LeverancierNummer,
                        l.Mobiel,
                        l.ContactId
                    FROM Leverancier l
                    ORDER BY l.Id ASC
                    LIMIT p_Limit OFFSET p_Offset;
                END
            ');

            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetLeverancierDetailsById`;');
            DB::unprepared('
                CREATE PROCEDURE `sp_GetLeverancierDetailsById`(
                    IN p_LeverancierId TINYINT UNSIGNED
                )
                BEGIN
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
                    WHERE l.Id = p_LeverancierId;
                END
            ');

            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetContactById`;');
            DB::unprepared('
                CREATE PROCEDURE `sp_GetContactById`(
                    IN p_ContactId TINYINT UNSIGNED
                )
                BEGIN
                    SELECT 
                        c.Id,
                        c.Straat,
                        c.Huisnummer,
                        c.Postcode,
                        c.Stad,
                        c.IsActief
                    FROM Contact c
                    WHERE c.Id = p_ContactId;
                END
            ');

            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_UpdateLeverancier`;');
            DB::unprepared("
                CREATE PROCEDURE `sp_UpdateLeverancier`(
                    IN p_LeverancierId TINYINT UNSIGNED,
                    IN p_Naam VARCHAR(100),
                    IN p_ContactPersoon VARCHAR(100),
                    IN p_LeverancierNummer VARCHAR(20),
                    IN p_Mobiel VARCHAR(15),
                    IN p_Straat VARCHAR(100),
                    IN p_Huisnummer VARCHAR(10),
                    IN p_Postcode VARCHAR(10),
                    IN p_Stad VARCHAR(100)
                )
                BEGIN
                    DECLARE v_ContactId TINYINT UNSIGNED;

                    IF p_LeverancierId = 5 THEN
                        SIGNAL SQLSTATE '45000'
                            SET MESSAGE_TEXT = 'Technische storing bij het wijzigen van leverancier De Bron';
                    END IF;

                    SELECT ContactId INTO v_ContactId
                    FROM Leverancier
                    WHERE Id = p_LeverancierId;

                    UPDATE Leverancier
                    SET Naam = p_Naam,
                        ContactPersoon = p_ContactPersoon,
                        LeverancierNummer = p_LeverancierNummer,
                        Mobiel = p_Mobiel,
                        DatumGewijzigd = SYSDATE(6)
                    WHERE Id = p_LeverancierId;

                    IF v_ContactId IS NOT NULL THEN
                        UPDATE Contact
                        SET Straat = p_Straat,
                            Huisnummer = p_Huisnummer,
                            Postcode = p_Postcode,
                            Stad = p_Stad,
                            DatumGewijzigd = SYSDATE(6)
                        WHERE Id = v_ContactId;
                    END IF;
                END
            ");
        }
    }

    /**
     * Verwijder de Stored Procedures van BE-opdracht 03.
     */
    public function down(): void
    {
        if (DB::connection()->getDriverName() === 'mysql') {
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_CountLeveranciers`;');
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetLeveranciersPaginated`;');
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetLeverancierDetailsById`;');
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_GetContactById`;');
            DB::unprepared('DROP PROCEDURE IF EXISTS `sp_UpdateLeverancier`;');
        }
    }
};
