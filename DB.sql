-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 17, 2023 at 07:45 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projekt`
--

-- --------------------------------------------------------

--
-- Table structure for table `knjiga`
--

CREATE TABLE `knjiga` (
  `Knjiga_ID` int(11) NOT NULL,
  `Naziv_knjige` varchar(45) DEFAULT NULL,
  `Opis` varchar(100) DEFAULT NULL,
  `Autor` varchar(45) DEFAULT NULL,
  `Korsinik_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `knjiga`
--

INSERT INTO `knjiga` (`Knjiga_ID`, `Naziv_knjige`, `Opis`, `Autor`, `Korsinik_ID`) VALUES
(1, 'Apple', 'Poduzece za razvoj mobilnih uredaja', '0-24', NULL),
(2, 'Microsoft', 'Poduzece za razvoj umjetne inteligencije', '8-16', NULL),
(3, 'Apple', 'asdasd', 'asdasdasd', NULL),
(4, 'Crvenkpica', 'Vuk lovi crvenkapicu', 'Bajka', NULL),
(5, 'Otac Goriot', 'Spletena drama', 'Honer de Blanc', NULL),
(6, 'Ana', 'Anica', 'Anuska', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

CREATE TABLE `korisnik` (
  `Korisnik_ID` int(11) NOT NULL,
  `Ime` varchar(50) DEFAULT NULL,
  `Prezime` varchar(50) DEFAULT NULL,
  `Lozinka` char(64) DEFAULT NULL,
  `Lozinka_Sha256` char(64) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL,
  `Blokiran` tinyint(1) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `Korisnicko_ime` varchar(45) DEFAULT NULL,
  `Korisnicka_uloga` int(11) DEFAULT NULL,
  `Zakljucan` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`Korisnik_ID`, `Ime`, `Prezime`, `Lozinka`, `Lozinka_Sha256`, `Email`, `Blokiran`, `Status`, `Korisnicko_ime`, `Korisnicka_uloga`, `Zakljucan`) VALUES
(1, 'ivan', 'gadzic', 'tunakralj', 'a7dccfacd35bc8aeeb58aef056e5fb841fa494ad', 'ivan.gadzic@gmail.com', 0, NULL, 'ivang', 1, 0),
(2, 'admin', 'admin', 'admin', '24303791641c1107e1aa9bd9d2e21244668fe64a', 'admin@gmail.com', NULL, NULL, 'admin', 0, 0),
(3, 'mod', 'mod', 'moderator', '20f56eecb60382af8d9bc590af6ecbeeaa59149d', 'moderator@gmail.com', NULL, NULL, 'moderator', 1, 0),
(4, 'doktor', 'znanosti', 'test', '1f7eea400fce89599ecde9bc2afb79f92c2b81d9', 'doktor@gmail.com', 1, NULL, 'doktor', 1, 0),
(5, 'tuna', 'tunic', 'tuna123', '413635647d9eeeaae30fd701c3e3e838f5c41405', 'tuna@gmail.com', 1, NULL, 'tunjo', 1, 0),
(6, 'ivan', 'gazda', 'ivano123', '30e84c12b5672e28a20b7297b8b1e716271f1c7f', 'ivaniviic@gmail.com', NULL, NULL, 'ivang123', 2, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `knjiga`
--
ALTER TABLE `knjiga`
  ADD PRIMARY KEY (`Knjiga_ID`),
  ADD KEY `fk_Poduzeće_Korisnik1_idx` (`Korsinik_ID`);

--
-- Indexes for table `korisnik`
--
ALTER TABLE `korisnik`
  ADD PRIMARY KEY (`Korisnik_ID`),
  ADD UNIQUE KEY `Korsinik_ID_UNIQUE` (`Korisnik_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `knjiga`
--
ALTER TABLE `knjiga`
  MODIFY `Knjiga_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `korisnik`
--
ALTER TABLE `korisnik`
  MODIFY `Korisnik_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `knjiga`
--
ALTER TABLE `knjiga`
  ADD CONSTRAINT `fk_Poduzeće_Korisnik1` FOREIGN KEY (`Korsinik_ID`) REFERENCES `korisnik` (`Korisnik_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
