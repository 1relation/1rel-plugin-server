-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Vært: localhost
-- Genereringstid: 15. 01 2024 kl. 11:16:15
-- Serverversion: 8.0.34
-- PHP-version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `1relation_com_db_pluginserver`
--

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `installedplugins`
--

CREATE TABLE `installedplugins` (
  `id` int NOT NULL,
  `pluginid` int NOT NULL,
  `identifier` varchar(50) NOT NULL,
  `privatetoken` mediumtext NOT NULL,
  `solutionid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur-dump for tabellen `plugins`
--

CREATE TABLE `plugins` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `publictoken` mediumtext NOT NULL,
  `blueprint` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Begrænsninger for dumpede tabeller
--

--
-- Indeks for tabel `installedplugins`
--
ALTER TABLE `installedplugins`
  ADD PRIMARY KEY (`id`);

--
-- Indeks for tabel `plugins`
--
ALTER TABLE `plugins`
  ADD PRIMARY KEY (`id`);

--
-- Brug ikke AUTO_INCREMENT for slettede tabeller
--

--
-- Tilføj AUTO_INCREMENT i tabel `installedplugins`
--
ALTER TABLE `installedplugins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Tilføj AUTO_INCREMENT i tabel `plugins`
--
ALTER TABLE `plugins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
