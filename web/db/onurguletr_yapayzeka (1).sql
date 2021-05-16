-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 16 May 2021, 03:47:31
-- Sunucu sürümü: 10.2.37-MariaDB-cll-lve
-- PHP Sürümü: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `yapayzeka`
--

DELIMITER $$
--
-- Yordamlar
--
CREATE DEFINER=`onurguletr`@`localhost` PROCEDURE `personDelete` (IN `fpid` INT)  NO SQL
BEGIN
DELETE FROM Relations WHERE Relations.fPID = fpid OR Relations.sPID = fpid;
DELETE FROM Faces WHERE Faces.PID = fpid;
DELETE FROM People WHERE PID = fpid;
END$$

CREATE DEFINER=`onurguletr`@`localhost` PROCEDURE `personMerge` (IN `fpid` INT, IN `spid` INT)  NO SQL
BEGIN
SET @fFaceCount = (SELECT COUNT(*) FROM Faces WHERE Faces.PID = fpid); 
SET @sFaceCount = (SELECT COUNT(*) FROM Faces WHERE Faces.PID = spid); 
IF (@fFaceCount >= @sFaceCount) THEN
UPDATE Faces SET PID = fpid WHERE PID = spid;
UPDATE Relations SET Relations.fPID = fpid WHERE fPID = spid;
UPDATE Relations SET Relations.sPID = fpid WHERE sPID = spid;
DELETE FROM People WHERE PID = spid;
ELSE
UPDATE Faces SET PID = spid WHERE PID = fpid;
UPDATE Relations SET Relations.fPID = spid WHERE fPID = fpid;
UPDATE Relations SET Relations.sPID = spid WHERE sPID = fpid;
DELETE FROM People WHERE PID = fpid;
END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Faces`
--

CREATE TABLE `Faces` (
  `FID` int(11) NOT NULL,
  `PID` int(11) NOT NULL COMMENT 'PersonID',
  `FaceImagePath` varchar(500) NOT NULL,
  `SourceImagePath` varchar(500) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `People`
--

CREATE TABLE `People` (
  `PID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `Relations`
--

CREATE TABLE `Relations` (
  `RID` int(11) NOT NULL COMMENT 'n! kere eklenecek.',
  `fPID` int(11) NOT NULL COMMENT 'firstPID',
  `sPID` int(11) NOT NULL COMMENT 'secondPID',
  `relationImagePath` varchar(500) NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp(),
  `disTop` int(11) NOT NULL COMMENT 'y distance',
  `disLeft` int(11) NOT NULL COMMENT 'x distance',
  `height` int(11) NOT NULL COMMENT 'height of main pic',
  `width` int(11) NOT NULL COMMENT 'width of main pic'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `Faces`
--
ALTER TABLE `Faces`
  ADD PRIMARY KEY (`FID`),
  ADD UNIQUE KEY `PID` (`PID`,`FaceImagePath`);

--
-- Tablo için indeksler `People`
--
ALTER TABLE `People`
  ADD PRIMARY KEY (`PID`);

--
-- Tablo için indeksler `Relations`
--
ALTER TABLE `Relations`
  ADD PRIMARY KEY (`RID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `Faces`
--
ALTER TABLE `Faces`
  MODIFY `FID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `People`
--
ALTER TABLE `People`
  MODIFY `PID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `Relations`
--
ALTER TABLE `Relations`
  MODIFY `RID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'n! kere eklenecek.';
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
