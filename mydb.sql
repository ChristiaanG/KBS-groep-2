-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 22 nov 2017 om 22:37
-- Serverversie: 10.1.26-MariaDB
-- PHP-versie: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mydb`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `category`
--

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `category`
--

INSERT INTO `category` (`categoryID`, `name`) VALUES
(1, 'computer'),
(2, 'laptop'),
(3, 'tablet'),
(4, 'smartphone'),
(5, 'tv'),
(6, 'printer'),
(7, 'versterker'),
(8, 'speakers'),
(9, 'algemeene electronica');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `customer`
--

CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phoneNr` varchar(45) NOT NULL,
  `cellphoneNr` varchar(45) DEFAULT NULL,
  `description` varchar(1045) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `customer`
--

INSERT INTO `customer` (`customerID`, `first_name`, `last_name`, `address`, `email`, `phoneNr`, `cellphoneNr`, `description`) VALUES
(18, 'jan', 'de boer', 'straat nummer dorp', 'test@test.nl', '123456', '0612345678', 'heeft een reparatise'),
(21, 'debora', 'devries', 'julianastraat 34', 'b.devries@xs4all.nl', '0523616754', '0634332689', ''),
(22, 'gerrit', 'vermeulen', 'langewijk 123', 'g.vermeulen@ziggo.nl', '0523123456', '0634761298', 'speelt professioneel luchtgitaar '),
(23, 'jantje', 'smit', 'volendam', 'j.smit@kpnplanet.nl', '0505050', '06314554645', NULL);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `device`
--

CREATE TABLE `device` (
  `deviceID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `deviceInfo` varchar(500) DEFAULT NULL,
  `serialnr` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `device`
--

INSERT INTO `device` (`deviceID`, `categoryID`, `deviceInfo`, `serialnr`) VALUES
(1, 1, 'test computer', '1234'),
(2, 5, 'sony bravia tv', '345543'),
(3, 3, 'samsung tab 2 10.1', '96546567');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `reparation`
--

CREATE TABLE `reparation` (
  `repairID` int(11) NOT NULL,
  `customerID` int(11) NOT NULL,
  `deviceID` int(11) NOT NULL,
  `statusID` int(11) NOT NULL,
  `description` varchar(535) NOT NULL,
  `chargerIncluded` tinyint(1) NOT NULL,
  `Status_reparatieID` int(11) NOT NULL,
  `daterepair` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `reparation`
--

INSERT INTO `reparation` (`repairID`, `customerID`, `deviceID`, `statusID`, `description`, `chargerIncluded`, `Status_reparatieID`, `daterepair`) VALUES
(1, 18, 1, 1, 'test reparatie', 1, 1, '2017-11-22 14:21:04'),
(2, 22, 2, 1, 'tv is niet chill', 1, 1, '2017-11-22 18:04:38'),
(3, 22, 3, 1, 'werkt niet meer na gooien tegen hoofd zoon', 1, 1, '2017-11-22 21:00:59');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `status`
--

CREATE TABLE `status` (
  `repairID` int(11) NOT NULL,
  `repairedBy` varchar(45) NOT NULL,
  `finished` tinyint(1) NOT NULL,
  `checked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `status`
--

INSERT INTO `status` (`repairID`, `repairedBy`, `finished`, `checked`) VALUES
(1, 'test', 0, 0);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `user`
--

CREATE TABLE `user` (
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  `name` varchar(45) NOT NULL,
  `role` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Gegevens worden geëxporteerd voor tabel `user`
--

INSERT INTO `user` (`username`, `password`, `name`, `role`) VALUES
('test', 'test', 'test gebruiker', 'test');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`);

--
-- Indexen voor tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexen voor tabel `device`
--
ALTER TABLE `device`
  ADD PRIMARY KEY (`deviceID`,`categoryID`),
  ADD KEY `fk_Apparaat_Categorie1_idx` (`categoryID`);

--
-- Indexen voor tabel `reparation`
--
ALTER TABLE `reparation`
  ADD PRIMARY KEY (`repairID`,`customerID`,`deviceID`,`Status_reparatieID`),
  ADD KEY `fk_Reparatie_Apparaat1_idx` (`deviceID`),
  ADD KEY `fk_Reparatie_Klant1_idx` (`customerID`),
  ADD KEY `fk_Reparatie_Status1_idx` (`Status_reparatieID`);

--
-- Indexen voor tabel `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`repairID`,`repairedBy`),
  ADD KEY `fk_Status_User1_idx` (`repairedBy`);

--
-- Indexen voor tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT voor een tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT voor een tabel `device`
--
ALTER TABLE `device`
  MODIFY `deviceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT voor een tabel `reparation`
--
ALTER TABLE `reparation`
  MODIFY `repairID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT voor een tabel `status`
--
ALTER TABLE `status`
  MODIFY `repairID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `device`
--
ALTER TABLE `device`
  ADD CONSTRAINT `fk_Apparaat_Categorie1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `reparation`
--
ALTER TABLE `reparation`
  ADD CONSTRAINT `fk_Reparatie_Apparaat1` FOREIGN KEY (`deviceID`) REFERENCES `device` (`deviceID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Reparatie_Klant1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Reparatie_Status1` FOREIGN KEY (`Status_reparatieID`) REFERENCES `status` (`repairID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Beperkingen voor tabel `status`
--
ALTER TABLE `status`
  ADD CONSTRAINT `fk_Status_User1` FOREIGN KEY (`repairedBy`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
