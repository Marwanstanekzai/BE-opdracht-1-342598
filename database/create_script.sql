-- Step: 01
-- Goal: Create or select database for Jamin Manager (BE-opdracht 03)
-- **********************************************************************************
-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            05-11-2026      Marwan                      Create 7 tables + data + relations for BE-opdracht 03
-- **********************************************************************************/

CREATE DATABASE IF NOT EXISTS `laravel` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `laravel`;

SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `ProductPerLeverancier`;
DROP TABLE IF EXISTS `ProductPerAllergeen`;
DROP TABLE IF EXISTS `Magazijn`;
DROP TABLE IF EXISTS `Leverancier`;
DROP TABLE IF EXISTS `Contact`;
DROP TABLE IF EXISTS `Allergeen`;
DROP TABLE IF EXISTS `Product`;

SET FOREIGN_KEY_CHECKS = 1;


-- Step: 02
-- Goal: Create table Contact
-- **********************************************************************************
CREATE TABLE IF NOT EXISTS `Contact`
(
    `Id`                TINYINT         UNSIGNED        NOT NULL    AUTO_INCREMENT
   ,`Straat`            VARCHAR(100)                    NOT NULL
   ,`Huisnummer`        VARCHAR(10)                     NOT NULL
   ,`Postcode`          VARCHAR(10)                     NOT NULL
   ,`Stad`              VARCHAR(100)                    NOT NULL
   ,`IsActief`          BIT                             NOT NULL    DEFAULT b'1'
   ,`Opmerking`         VARCHAR(250)                        NULL    DEFAULT NULL
   ,`DatumAangemaakt`   DATETIME(6)                     NOT NULL
   ,`DatumGewijzigd`    DATETIME(6)                     NOT NULL

   ,CONSTRAINT `PK_Contact_Id` PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Step: 03
-- Goal: Fill table Contact with data
-- **********************************************************************************
INSERT INTO `Contact`
(
     `Id`
    ,`Straat`
    ,`Huisnummer`
    ,`Postcode`
    ,`Stad`
    ,`IsActief`
    ,`Opmerking`
    ,`DatumAangemaakt`
    ,`DatumGewijzigd`
)
VALUES
     (1, 'Van Gilslaan', '34', '1045CB', 'Hilvarenbeek', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(2, 'Den Dolderpad', '2', '1067RC', 'Utrecht', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(3, 'Fredo Raalteweg', '257', '1236OP', 'Nijmegen', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(4, 'Bertrand Russellhof', '21', '2034AP', 'Den Haag', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(5, 'Leon van Bonstraat', '213', '145XC', 'Lunteren', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(6, 'Bea van Lingenlaan', '234', '2197FG', 'Sint Pancras', b'1', NULL, SYSDATE(6), SYSDATE(6));


-- Step: 04
-- Goal: Create table Leverancier
-- **********************************************************************************
CREATE TABLE IF NOT EXISTS `Leverancier`
(
    `Id`                TINYINT         UNSIGNED        NOT NULL    AUTO_INCREMENT
   ,`Naam`              VARCHAR(100)                    NOT NULL
   ,`ContactPersoon`    VARCHAR(100)                    NOT NULL
   ,`LeverancierNummer` VARCHAR(20)                     NOT NULL
   ,`Mobiel`            VARCHAR(15)                     NOT NULL
   ,`ContactId`         TINYINT         UNSIGNED            NULL
   ,`IsActief`          BIT                             NOT NULL    DEFAULT b'1'
   ,`Opmerking`         VARCHAR(250)                        NULL    DEFAULT NULL
   ,`DatumAangemaakt`   DATETIME(6)                     NOT NULL
   ,`DatumGewijzigd`    DATETIME(6)                     NOT NULL

   ,CONSTRAINT `PK_Leverancier_Id` PRIMARY KEY (`Id`)
   ,CONSTRAINT `FK_Leverancier_ContactId_Contact_Id` FOREIGN KEY (`ContactId`) REFERENCES `Contact` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Step: 05
-- Goal: Fill table Leverancier with data (including Quality Street)
-- **********************************************************************************
INSERT INTO `Leverancier`
(
     `Id`
    ,`Naam`
    ,`ContactPersoon`
    ,`LeverancierNummer`
    ,`Mobiel`
    ,`ContactId`
    ,`IsActief`
    ,`Opmerking`
    ,`DatumAangemaakt`
    ,`DatumGewijzigd`
)
VALUES
     (1, 'Venco', 'Bert van Linge', 'L1029384719', '06-28493827', 1, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(2, 'Astra Sweets', 'Jasper del Monte', 'L1029284315', '06-39398734', 2, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(3, 'Haribo', 'Sven Stalman', 'L1029324748', '06-24383291', 3, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(4, 'Basset', 'Joyce Stelterberg', 'L1023845773', '06-48293823', 4, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(5, 'De Bron', 'Remco Veenstra', 'L1023857736', '06-34291234', 5, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(6, 'Quality Street', 'Johan Nooij', 'L1029234586', '06-23458456', 6, b'1', NULL, SYSDATE(6), SYSDATE(6));


-- Step: 06
-- Goal: Create table Product
-- **********************************************************************************
CREATE TABLE IF NOT EXISTS `Product`
(
    `Id`                TINYINT         UNSIGNED        NOT NULL    AUTO_INCREMENT
   ,`Naam`              VARCHAR(100)                    NOT NULL
   ,`Barcode`           VARCHAR(13)                     NOT NULL
   ,`IsActief`          BIT                             NOT NULL    DEFAULT b'1'
   ,`Opmerking`         VARCHAR(250)                        NULL    DEFAULT NULL
   ,`DatumAangemaakt`   DATETIME(6)                     NOT NULL
   ,`DatumGewijzigd`    DATETIME(6)                     NOT NULL

   ,CONSTRAINT `PK_Product_Id` PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Step: 07
-- Goal: Fill table Product with data
-- **********************************************************************************
INSERT INTO `Product`
(
     `Id`
    ,`Naam`
    ,`Barcode`
    ,`IsActief`
    ,`Opmerking`
    ,`DatumAangemaakt`
    ,`DatumGewijzigd`
)
VALUES
     (1, 'Mintnopjes', '8719587231278', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(2, 'Schoolkrijt', '8719587326713', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(3, 'Honingdrop', '8719587327836', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(4, 'Zure Beren', '8719587321441', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(5, 'Cola Flesjes', '8719587321237', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(6, 'Turtles', '8719587322245', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(7, 'Witte Muizen', '8719587328256', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(8, 'Reuzen Slangen', '8719587325641', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(9, 'Zoute Rijen', '8719587322739', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(10, 'Winegums', '8719587327527', b'0', NULL, SYSDATE(6), SYSDATE(6))
    ,(11, 'Drop Munten', '8719587322345', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(12, 'Kruis Drop', '8719587322265', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(13, 'Zoute Ruitjes', '8719587323256', b'1', NULL, SYSDATE(6), SYSDATE(6));


-- Step: 08
-- Goal: Create table Magazijn
-- **********************************************************************************
CREATE TABLE IF NOT EXISTS `Magazijn`
(
    `Id`                TINYINT         UNSIGNED        NOT NULL    AUTO_INCREMENT
   ,`ProductId`         TINYINT         UNSIGNED        NOT NULL
   ,`VerpakkingsEenheid` DECIMAL(8,3)                   NOT NULL
   ,`AantalAanwezig`    INT             UNSIGNED            NULL
   ,`IsActief`          BIT                             NOT NULL    DEFAULT b'1'
   ,`Opmerking`         VARCHAR(250)                        NULL    DEFAULT NULL
   ,`DatumAangemaakt`   DATETIME(6)                     NOT NULL
   ,`DatumGewijzigd`    DATETIME(6)                     NOT NULL

   ,CONSTRAINT `PK_Magazijn_Id` PRIMARY KEY (`Id`)
   ,CONSTRAINT `FK_Magazijn_ProductId_Product_Id` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Step: 09
-- Goal: Fill table Magazijn with data
-- **********************************************************************************
INSERT INTO `Magazijn`
(
     `Id`
    ,`ProductId`
    ,`VerpakkingsEenheid`
    ,`AantalAanwezig`
    ,`IsActief`
    ,`Opmerking`
    ,`DatumAangemaakt`
    ,`DatumGewijzigd`
)
VALUES
     (1, 1, 5.000, 453, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(2, 2, 2.500, 400, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(3, 3, 5.000, 1, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(4, 4, 1.000, 800, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(5, 5, 3.000, 234, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(6, 6, 2.000, 345, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(7, 7, 1.000, 795, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(8, 8, 10.000, 233, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(9, 9, 2.500, 123, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(10, 10, 3.000, NULL, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(11, 11, 2.000, 367, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(12, 12, 1.000, 467, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(13, 13, 5.000, 20, b'1', NULL, SYSDATE(6), SYSDATE(6));


-- Step: 10
-- Goal: Create table Allergeen
-- **********************************************************************************
CREATE TABLE IF NOT EXISTS `Allergeen`
(
    `Id`                TINYINT         UNSIGNED        NOT NULL    AUTO_INCREMENT
   ,`Naam`              VARCHAR(100)                    NOT NULL
   ,`Omschrijving`      VARCHAR(250)                    NOT NULL
   ,`IsActief`          BIT                             NOT NULL    DEFAULT b'1'
   ,`Opmerking`         VARCHAR(250)                        NULL    DEFAULT NULL
   ,`DatumAangemaakt`   DATETIME(6)                     NOT NULL
   ,`DatumGewijzigd`    DATETIME(6)                     NOT NULL

   ,CONSTRAINT `PK_Allergeen_Id` PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Step: 11
-- Goal: Fill table Allergeen with data
-- **********************************************************************************
INSERT INTO `Allergeen`
(
     `Id`
    ,`Naam`
    ,`Omschrijving`
    ,`IsActief`
    ,`Opmerking`
    ,`DatumAangemaakt`
    ,`DatumGewijzigd`
)
VALUES
     (1, 'Gluten', 'Dit product bevat gluten', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(2, 'Gelatine', 'Dit product bevat gelatine', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(3, 'AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(4, 'Lactose', 'Dit product bevat lactose', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(5, 'Soja', 'Dit product bevat soja', b'1', NULL, SYSDATE(6), SYSDATE(6));


-- Step: 12
-- Goal: Create table ProductPerAllergeen
-- **********************************************************************************
CREATE TABLE IF NOT EXISTS `ProductPerAllergeen`
(
    `Id`                TINYINT         UNSIGNED        NOT NULL    AUTO_INCREMENT
   ,`ProductId`         TINYINT         UNSIGNED        NOT NULL
   ,`AllergeenId`       TINYINT         UNSIGNED        NOT NULL
   ,`IsActief`          BIT                             NOT NULL    DEFAULT b'1'
   ,`Opmerking`         VARCHAR(250)                        NULL    DEFAULT NULL
   ,`DatumAangemaakt`   DATETIME(6)                     NOT NULL
   ,`DatumGewijzigd`    DATETIME(6)                     NOT NULL

   ,CONSTRAINT `PK_ProductPerAllergeen_Id` PRIMARY KEY (`Id`)
   ,CONSTRAINT `FK_ProductPerAllergeen_ProductId_Product_Id` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
   ,CONSTRAINT `FK_ProductPerAllergeen_AllergeenId_Allergeen_Id` FOREIGN KEY (`AllergeenId`) REFERENCES `Allergeen` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Step: 13
-- Goal: Fill table ProductPerAllergeen with data
-- **********************************************************************************
INSERT INTO `ProductPerAllergeen`
(
     `Id`
    ,`ProductId`
    ,`AllergeenId`
    ,`IsActief`
    ,`Opmerking`
    ,`DatumAangemaakt`
    ,`DatumGewijzigd`
)
VALUES
     (1, 1, 2, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(2, 1, 1, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(3, 1, 3, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(4, 3, 4, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(5, 6, 5, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(6, 9, 2, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(7, 9, 5, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(8, 10, 2, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(9, 12, 4, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(10, 13, 1, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(11, 13, 4, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(12, 13, 5, b'1', NULL, SYSDATE(6), SYSDATE(6));


-- Step: 14
-- Goal: Create table ProductPerLeverancier
-- **********************************************************************************
CREATE TABLE IF NOT EXISTS `ProductPerLeverancier`
(
    `Id`                         TINYINT         UNSIGNED        NOT NULL    AUTO_INCREMENT
   ,`LeverancierId`              TINYINT         UNSIGNED        NOT NULL
   ,`ProductId`                  TINYINT         UNSIGNED        NOT NULL
   ,`DatumLevering`              DATE                            NOT NULL
   ,`Aantal`                     INT             UNSIGNED        NOT NULL
   ,`DatumEerstVolgendeLevering` DATE                                NULL    DEFAULT NULL
   ,`IsActief`                   BIT                             NOT NULL    DEFAULT b'1'
   ,`Opmerking`                  VARCHAR(250)                        NULL    DEFAULT NULL
   ,`DatumAangemaakt`            DATETIME(6)                     NOT NULL
   ,`DatumGewijzigd`             DATETIME(6)                     NOT NULL

   ,CONSTRAINT `PK_ProductPerLeverancier_Id` PRIMARY KEY (`Id`)
   ,CONSTRAINT `FK_ProductPerLeverancier_LeverancierId_Leverancier_Id` FOREIGN KEY (`LeverancierId`) REFERENCES `Leverancier` (`Id`)
   ,CONSTRAINT `FK_ProductPerLeverancier_ProductId_Product_Id` FOREIGN KEY (`ProductId`) REFERENCES `Product` (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Step: 15
-- Goal: Fill table ProductPerLeverancier with data
-- Toelichting dubbele Id 14 uit de opdracht:
-- In de aangeleverde tabel van BE-opdracht 03 komt Id 14 twee keer voor bij LeverancierId 5 (ProductId 11).
-- Omdat Id een unieke Primary Key is, heeft de tweede levering van ProductId 11 (op 2023-04-19 met Aantal 60)
-- het opvolgende Id 15 gekregen en zijn de laatste twee rijen doorgenummerd naar Id 16 en Id 17.
-- Zo blijven alle 17 leveringsregels en hun exacte gegevens behouden.
-- **********************************************************************************
INSERT INTO `ProductPerLeverancier`
(
     `Id`
    ,`LeverancierId`
    ,`ProductId`
    ,`DatumLevering`
    ,`Aantal`
    ,`DatumEerstVolgendeLevering`
    ,`IsActief`
    ,`Opmerking`
    ,`DatumAangemaakt`
    ,`DatumGewijzigd`
)
VALUES
     (1, 1, 1, '2023-04-09', 23, '2023-04-16', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(2, 1, 1, '2023-04-18', 21, '2023-04-25', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(3, 1, 2, '2023-04-09', 12, '2023-04-16', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(4, 1, 3, '2023-04-10', 11, '2023-04-17', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(5, 2, 4, '2023-04-14', 16, '2023-04-21', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(6, 2, 4, '2023-04-21', 23, '2023-04-28', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(7, 2, 5, '2023-04-14', 45, '2023-04-21', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(8, 2, 6, '2023-04-14', 30, '2023-04-21', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(9, 3, 7, '2023-04-12', 12, '2023-04-19', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(10, 3, 7, '2023-04-19', 23, '2023-04-26', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(11, 3, 8, '2023-04-10', 12, '2023-04-17', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(12, 3, 9, '2023-04-11', 1, '2023-04-18', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(13, 4, 10, '2023-04-16', 24, '2023-04-30', b'0', NULL, SYSDATE(6), SYSDATE(6))
    ,(14, 5, 11, '2023-04-10', 47, '2023-04-17', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(15, 5, 11, '2023-04-19', 60, '2023-04-26', b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(16, 5, 12, '2023-04-11', 45, NULL, b'1', NULL, SYSDATE(6), SYSDATE(6))
    ,(17, 5, 13, '2023-04-12', 23, NULL, b'1', NULL, SYSDATE(6), SYSDATE(6));
