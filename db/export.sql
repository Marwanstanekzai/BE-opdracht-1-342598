-- Database Export: Jamin Manager (BE-opdracht 01, 02 & 03)
-- Bevat alle 7 tabellen (Contact, Leverancier, Product, Magazijn, Allergeen, ProductPerAllergeen, ProductPerLeverancier),
-- relaties, testgegevens en Stored Procedures.

CREATE DATABASE IF NOT EXISTS `laravel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `laravel`;

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `ProductPerLeverancier`;
DROP TABLE IF EXISTS `ProductPerAllergeen`;
DROP TABLE IF EXISTS `Magazijn`;
DROP TABLE IF EXISTS `Leverancier`;
DROP TABLE IF EXISTS `Contact`;
DROP TABLE IF EXISTS `Allergeen`;
DROP TABLE IF EXISTS `Product`;

CREATE TABLE `Contact` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Straat` varchar(100) NOT NULL,
  `Huisnummer` varchar(10) NOT NULL,
  `Postcode` varchar(10) NOT NULL,
  `Stad` varchar(100) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Contact` (`Id`, `Straat`, `Huisnummer`, `Postcode`, `Stad`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Van Gilslaan', '34', '1045CB', 'Hilvarenbeek', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'Den Dolderpad', '2', '1067RC', 'Utrecht', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'Fredo Raalteweg', '257', '1236OP', 'Nijmegen', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 'Bertrand Russellhof', '21', '2034AP', 'Den Haag', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 'Leon van Bonstraat', '213', '145XC', 'Lunteren', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 'Bea van Lingenlaan', '234', '2197FG', 'Sint Pancras', b'1', NULL, SYSDATE(6), SYSDATE(6));

CREATE TABLE `Product` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Barcode` varchar(13) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Product` (`Id`, `Naam`, `Barcode`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Mintnopjes', '8719587231278', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'Schoolkrijt', '8719587326713', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'Honingdrop', '8719587327836', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 'Zure Beren', '8719587321441', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 'Cola Flesjes', '8719587321237', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 'Turtles', '8719587322245', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 'Witte Muizen', '8719587328256', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 'Reuzen Slangen', '8719587325641', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 'Zoute Rijen', '8719587322739', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 'Winegums', '8719587327527', b'0', NULL, SYSDATE(6), SYSDATE(6)),
(11, 'Drop Munten', '8719587322345', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 'Kruis Drop', '8719587322265', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, 'Zoute Ruitjes', '8719587323256', b'1', NULL, SYSDATE(6), SYSDATE(6));

CREATE TABLE `Magazijn` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `ProductId` tinyint(3) unsigned NOT NULL,
  `VerpakkingsEenheid` decimal(8,3) NOT NULL,
  `AantalAanwezig` int(10) unsigned DEFAULT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `magazijn_productid_foreign` (`ProductId`),
  CONSTRAINT `magazijn_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Magazijn` (`Id`, `ProductId`, `VerpakkingsEenheid`, `AantalAanwezig`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 5.000, 453, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 2, 2.500, 400, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 3, 5.000, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 4, 1.000, 800, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 5, 3.000, 234, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 6, 2.000, 345, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 7, 1.000, 795, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 8, 10.000, 233, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 9, 2.500, 123, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 10, 3.000, NULL, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, 11, 2.000, 367, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 12, 1.000, 467, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, 13, 5.000, 20, b'1', NULL, SYSDATE(6), SYSDATE(6));

CREATE TABLE `Allergeen` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Omschrijving` varchar(250) NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Allergeen` (`Id`, `Naam`, `Omschrijving`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Gluten', 'Dit product bevat gluten', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'Gelatine', 'Dit product bevat gelatine', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 'Lactose', 'Dit product bevat lactose', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 'Soja', 'Dit product bevat soja', b'1', NULL, SYSDATE(6), SYSDATE(6));

CREATE TABLE `ProductPerAllergeen` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `ProductId` tinyint(3) unsigned NOT NULL,
  `AllergeenId` tinyint(3) unsigned NOT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `productperallergeen_productid_foreign` (`ProductId`),
  KEY `productperallergeen_allergeenid_foreign` (`AllergeenId`),
  CONSTRAINT `productperallergeen_allergeenid_foreign` FOREIGN KEY (`AllergeenId`) REFERENCES `Allergeen` (`Id`),
  CONSTRAINT `productperallergeen_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ProductPerAllergeen` (`Id`, `ProductId`, `AllergeenId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 1, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 1, 3, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 3, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 6, 5, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 9, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 9, 5, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 10, 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 12, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 13, 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, 13, 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 13, 5, b'1', NULL, SYSDATE(6), SYSDATE(6));

CREATE TABLE `Leverancier` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `ContactPersoon` varchar(100) NOT NULL,
  `LeverancierNummer` varchar(20) NOT NULL,
  `Mobiel` varchar(15) NOT NULL,
  `ContactId` tinyint(3) unsigned DEFAULT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `leverancier_contactid_foreign` (`ContactId`),
  CONSTRAINT `leverancier_contactid_foreign` FOREIGN KEY (`ContactId`) REFERENCES `Contact` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Leverancier` (`Id`, `Naam`, `ContactPersoon`, `LeverancierNummer`, `Mobiel`, `ContactId`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 'Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 2, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 'Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 3, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 'Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 4, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 'De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 5, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 'Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 6, b'1', NULL, SYSDATE(6), SYSDATE(6));

CREATE TABLE `ProductPerLeverancier` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `LeverancierId` tinyint(3) unsigned NOT NULL,
  `ProductId` tinyint(3) unsigned NOT NULL,
  `DatumLevering` date NOT NULL,
  `Aantal` int(10) unsigned NOT NULL,
  `DatumEerstVolgendeLevering` date DEFAULT NULL,
  `IsActief` bit(1) NOT NULL DEFAULT b'1',
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `productperleverancier_leverancierid_foreign` (`LeverancierId`),
  KEY `productperleverancier_productid_foreign` (`ProductId`),
  CONSTRAINT `productperleverancier_leverancierid_foreign` FOREIGN KEY (`LeverancierId`) REFERENCES `Leverancier` (`Id`),
  CONSTRAINT `productperleverancier_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Toelichting dubbele Id 14 uit de opdracht:
-- De tweede levering van ProductId 11 (2023-04-19, aantal 60) heeft het opvolgende Id 15 gekregen
-- en de laatste twee regels hebben Id 16 en Id 17 gekregen zodat alle 17 leveringen behouden blijven.
INSERT INTO `ProductPerLeverancier` (`Id`, `LeverancierId`, `ProductId`, `DatumLevering`, `Aantal`, `DatumEerstVolgendeLevering`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, '2023-04-09', 23, '2023-04-16', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(2, 1, 1, '2023-04-18', 21, '2023-04-25', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(3, 1, 2, '2023-04-09', 12, '2023-04-16', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(4, 1, 3, '2023-04-10', 11, '2023-04-17', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(5, 2, 4, '2023-04-14', 16, '2023-04-21', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(6, 2, 4, '2023-04-21', 23, '2023-04-28', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(7, 2, 5, '2023-04-14', 45, '2023-04-21', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(8, 2, 6, '2023-04-14', 30, '2023-04-21', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(9, 3, 7, '2023-04-12', 12, '2023-04-19', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(10, 3, 7, '2023-04-19', 23, '2023-04-26', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(11, 3, 8, '2023-04-10', 12, '2023-04-17', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(12, 3, 9, '2023-04-11', 1, '2023-04-18', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(13, 4, 10, '2023-04-16', 24, '2023-04-30', b'0', NULL, SYSDATE(6), SYSDATE(6)),
(14, 5, 11, '2023-04-10', 47, '2023-04-17', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(15, 5, 11, '2023-04-19', 60, '2023-04-26', b'1', NULL, SYSDATE(6), SYSDATE(6)),
(16, 5, 12, '2023-04-11', 45, NULL, b'1', NULL, SYSDATE(6), SYSDATE(6)),
(17, 5, 13, '2023-04-12', 23, NULL, b'1', NULL, SYSDATE(6), SYSDATE(6));

SET FOREIGN_KEY_CHECKS=1;

-- --------------------------------------------------------
-- Stored Procedures voor BE-opdracht 02 & BE-opdracht 03
-- --------------------------------------------------------

DELIMITER $$

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

DROP PROCEDURE IF EXISTS `sp_CountLeveranciers`$$
CREATE PROCEDURE `sp_CountLeveranciers`()
BEGIN
    SELECT COUNT(*) AS Totaal FROM Leverancier;
END$$

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
