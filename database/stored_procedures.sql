-- **********************************************************************************
-- Stored Procedures voor Jamin Manager (BE-opdracht 02 & BE-opdracht 03)
-- **********************************************************************************

USE `laravel`;

DELIMITER $$

-- ----------------------------------------------------------------------------------
-- BE-opdracht 02: Overzicht leveranciers met aantal verschillende producten
-- ----------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_GetLeveranciersOverzicht`$$
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
END$$

-- ----------------------------------------------------------------------------------
-- BE-opdracht 02: Specifieke leverancier ophalen op Id
-- ----------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_GetLeverancierById`$$
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
        l.ContactId,
        l.IsActief
    FROM Leverancier l
    WHERE l.Id = p_LeverancierId;
END$$

-- ----------------------------------------------------------------------------------
-- BE-opdracht 02: Geleverde producten per leverancier ophalen
-- ----------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_GetGeleverdeProductenByLeverancierId`$$
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
END$$

-- ----------------------------------------------------------------------------------
-- BE-opdracht 02: Product en leverancier ophalen voor nieuwe levering
-- ----------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_GetProductVoorLevering`$$
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
END$$

-- ----------------------------------------------------------------------------------
-- BE-opdracht 02: Productlevering toevoegen en voorraad verhogen
-- ----------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_AddProductLevering`$$
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
END$$

-- ----------------------------------------------------------------------------------
-- BE-opdracht 03 (1): Totaal aantal leveranciers ophalen voor server-side pagination
-- ----------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_CountLeveranciers`$$
CREATE PROCEDURE `sp_CountLeveranciers`()
BEGIN
    SELECT COUNT(*) AS Totaal FROM Leverancier;
END$$

-- ----------------------------------------------------------------------------------
-- BE-opdracht 03 (1): Gepagineerd overzicht leveranciers ophalen (server-side LIMIT/OFFSET)
-- ----------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_GetLeveranciersPaginated`$$
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
END$$

-- ----------------------------------------------------------------------------------
-- BE-opdracht 03 (2 & 3): Leverancier- én Contactgegevens ophalen voor Details en Wijzigen
-- ----------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_GetLeverancierDetailsById`$$
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
END$$

-- ----------------------------------------------------------------------------------
-- BE-opdracht 03 (3): Contactgegevens afzonderlijk ophalen op ContactId
-- ----------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_GetContactById`$$
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
END$$

-- ----------------------------------------------------------------------------------
-- BE-opdracht 03 (4): Leveranciergegevens en bijbehorende Contactgegevens wijzigen
-- ----------------------------------------------------------------------------------
DROP PROCEDURE IF EXISTS `sp_UpdateLeverancier`$$
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

    -- Scenario 02: Bij leverancier De Bron (Id = 5) treedt een technische storing op
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
END$$

DELIMITER ;
