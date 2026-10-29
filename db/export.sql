-- Database Export: Mvc-2209a-P4 / schoolapp
-- Generated for BE-opdracht-1

SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `ProductPerLeverancier`;
DROP TABLE IF EXISTS `ProductPerAllergeen`;
DROP TABLE IF EXISTS `Magazijn`;
DROP TABLE IF EXISTS `Leverancier`;
DROP TABLE IF EXISTS `Allergeen`;
DROP TABLE IF EXISTS `Product`;

CREATE TABLE `Product` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Barcode` varchar(13) NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Product` (`Id`, `Naam`, `Barcode`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Mintnopjes', '8719587231278', 1, NULL, NOW(), NOW()),
(2, 'Schoolkrijt', '8719587326713', 1, NULL, NOW(), NOW()),
(3, 'Honingdrop', '8719587327836', 1, NULL, NOW(), NOW()),
(4, 'Zure Beren', '8719587321441', 1, NULL, NOW(), NOW()),
(5, 'Cola Flesjes', '8719587321237', 1, NULL, NOW(), NOW()),
(6, 'Turtles', '8719587322245', 1, NULL, NOW(), NOW()),
(7, 'Witte Muizen', '8719587328256', 1, NULL, NOW(), NOW()),
(8, 'Reuzen Slangen', '8719587325641', 1, NULL, NOW(), NOW()),
(9, 'Zoute Rijen', '8719587322739', 1, NULL, NOW(), NOW()),
(10, 'Winegums', '8719587327527', 0, NULL, NOW(), NOW()),
(11, 'Drop Munten', '8719587322345', 1, NULL, NOW(), NOW()),
(12, 'Kruis Drop', '8719587322265', 1, NULL, NOW(), NOW()),
(13, 'Zoute Ruitjes', '8719587323256', 1, NULL, NOW(), NOW());

CREATE TABLE `Magazijn` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `ProductId` tinyint(3) unsigned NOT NULL,
  `VerpakkingsEenheid` decimal(8,3) NOT NULL,
  `AantalAanwezig` int(10) unsigned DEFAULT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `magazijn_productid_foreign` (`ProductId`),
  CONSTRAINT `magazijn_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Magazijn` (`Id`, `ProductId`, `VerpakkingsEenheid`, `AantalAanwezig`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 5.000, 453, 1, NULL, NOW(), NOW()),
(2, 2, 2.500, 400, 1, NULL, NOW(), NOW()),
(3, 3, 5.000, 1, 1, NULL, NOW(), NOW()),
(4, 4, 1.000, 800, 1, NULL, NOW(), NOW()),
(5, 5, 3.000, 234, 1, NULL, NOW(), NOW()),
(6, 6, 2.000, 345, 1, NULL, NOW(), NOW()),
(7, 7, 1.000, 795, 1, NULL, NOW(), NOW()),
(8, 8, 10.000, 233, 1, NULL, NOW(), NOW()),
(9, 9, 2.500, 123, 1, NULL, NOW(), NOW()),
(10, 10, 3.000, NULL, 1, NULL, NOW(), NOW()),
(11, 11, 2.000, 367, 1, NULL, NOW(), NOW()),
(12, 12, 1.000, 467, 1, NULL, NOW(), NOW()),
(13, 13, 5.000, 20, 1, NULL, NOW(), NOW());

CREATE TABLE `Allergeen` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `Omschrijving` varchar(250) NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Allergeen` (`Id`, `Naam`, `Omschrijving`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Gluten', 'Dit product bevat gluten', 1, NULL, NOW(), NOW()),
(2, 'Gelatine', 'Dit product bevat gelatine', 1, NULL, NOW(), NOW()),
(3, 'AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen', 1, NULL, NOW(), NOW()),
(4, 'Lactose', 'Dit product bevat lactose', 1, NULL, NOW(), NOW()),
(5, 'Soja', 'Dit product bevat soja', 1, NULL, NOW(), NOW());

CREATE TABLE `ProductPerAllergeen` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `ProductId` tinyint(3) unsigned NOT NULL,
  `AllergeenId` tinyint(3) unsigned NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
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
(1, 1, 2, 1, NULL, NOW(), NOW()),
(2, 1, 1, 1, NULL, NOW(), NOW()),
(3, 1, 3, 1, NULL, NOW(), NOW()),
(4, 3, 4, 1, NULL, NOW(), NOW()),
(5, 6, 5, 1, NULL, NOW(), NOW()),
(6, 9, 2, 1, NULL, NOW(), NOW()),
(7, 9, 5, 1, NULL, NOW(), NOW()),
(8, 10, 2, 1, NULL, NOW(), NOW()),
(9, 12, 4, 1, NULL, NOW(), NOW()),
(10, 13, 1, 1, NULL, NOW(), NOW()),
(11, 13, 4, 1, NULL, NOW(), NOW()),
(12, 13, 5, 1, NULL, NOW(), NOW());

CREATE TABLE `Leverancier` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `Naam` varchar(100) NOT NULL,
  `ContactPersoon` varchar(100) NOT NULL,
  `LeverancierNummer` varchar(20) NOT NULL,
  `Mobiel` varchar(15) NOT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `Leverancier` (`Id`, `Naam`, `ContactPersoon`, `LeverancierNummer`, `Mobiel`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 'Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1, NULL, NOW(), NOW()),
(2, 'Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 1, NULL, NOW(), NOW()),
(3, 'Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 1, NULL, NOW(), NOW()),
(4, 'Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 1, NULL, NOW(), NOW()),
(5, 'De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 1, NULL, NOW(), NOW()),
(6, 'Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 1, NULL, NOW(), NOW());

CREATE TABLE `ProductPerLeverancier` (
  `Id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `LeverancierId` tinyint(3) unsigned NOT NULL,
  `ProductId` tinyint(3) unsigned NOT NULL,
  `DatumLevering` date NOT NULL,
  `Aantal` int(10) unsigned NOT NULL,
  `DatumEerstVolgendeLevering` date DEFAULT NULL,
  `IsActief` tinyint(1) NOT NULL DEFAULT 1,
  `Opmerking` varchar(250) DEFAULT NULL,
  `DatumAangemaakt` datetime(6) NOT NULL,
  `DatumGewijzigd` datetime(6) NOT NULL,
  PRIMARY KEY (`Id`),
  KEY `productperleverancier_leverancierid_foreign` (`LeverancierId`),
  KEY `productperleverancier_productid_foreign` (`ProductId`),
  CONSTRAINT `productperleverancier_leverancierid_foreign` FOREIGN KEY (`LeverancierId`) REFERENCES `Leverancier` (`Id`),
  CONSTRAINT `productperleverancier_productid_foreign` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `ProductPerLeverancier` (`Id`, `LeverancierId`, `ProductId`, `DatumLevering`, `Aantal`, `DatumEerstVolgendeLevering`, `IsActief`, `Opmerking`, `DatumAangemaakt`, `DatumGewijzigd`) VALUES
(1, 1, 1, '2024-10-09', 23, '2024-10-16', 1, NULL, NOW(), NOW()),
(2, 1, 1, '2024-10-18', 21, '2024-10-25', 1, NULL, NOW(), NOW()),
(3, 1, 2, '2024-10-09', 12, '2024-10-16', 1, NULL, NOW(), NOW()),
(4, 1, 3, '2024-10-10', 11, '2024-10-17', 1, NULL, NOW(), NOW()),
(5, 2, 4, '2024-10-14', 16, '2024-10-21', 1, NULL, NOW(), NOW()),
(6, 2, 4, '2024-10-21', 23, '2024-10-28', 1, NULL, NOW(), NOW()),
(7, 2, 5, '2024-10-14', 45, '2024-10-21', 1, NULL, NOW(), NOW()),
(8, 2, 6, '2024-10-14', 30, '2024-10-21', 1, NULL, NOW(), NOW()),
(9, 3, 7, '2024-10-12', 12, '2024-10-19', 1, NULL, NOW(), NOW()),
(10, 3, 7, '2024-10-19', 23, '2024-10-26', 1, NULL, NOW(), NOW()),
(11, 3, 8, '2024-10-10', 12, '2024-10-17', 1, NULL, NOW(), NOW()),
(12, 3, 9, '2024-10-11', 1, '2024-10-18', 1, NULL, NOW(), NOW()),
(13, 4, 10, '2024-10-16', 24, '2023-04-30', 0, NULL, NOW(), NOW()),
(14, 5, 11, '2024-10-10', 47, '2024-10-17', 1, NULL, NOW(), NOW()),
(15, 5, 11, '2024-10-19', 60, '2024-10-26', 1, NULL, NOW(), NOW()),
(16, 5, 12, '2024-10-11', 45, NULL, 1, NULL, NOW(), NOW()),
(17, 5, 13, '2024-10-12', 23, NULL, 1, NULL, NOW(), NOW());

SET FOREIGN_KEY_CHECKS=1;

-- --------------------------------------------------------
-- Stored Procedures for BE-opdracht 02
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

DELIMITER ;

