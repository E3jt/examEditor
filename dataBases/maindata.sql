-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2024 at 08:13 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `maindata`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `classes`
--

CREATE TABLE `classes` (
  `class` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`class`) VALUES
('3TP');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `credentials`
--

CREATE TABLE `credentials` (
  `ID` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` tinytext NOT NULL,
  `surname` tinytext NOT NULL,
  `permissionLevel` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `credentials`
--

INSERT INTO `credentials` (`ID`, `login`, `password`, `name`, `surname`, `permissionLevel`) VALUES
(1, 'admin', 'ahaokspoko13', '', '', 5),
(2, 'aha', 'okspoko', 'Rafał', 'Sekator', 0),
(3, 'csoa', '123', 'tr', 'tr', 0),
(4, 'alamakota', 'makota', 'Łukasz', 'Gaszewski', 5);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `examshistory`
--

CREATE TABLE `examshistory` (
  `examId` int(11) NOT NULL,
  `startingDate` datetime NOT NULL,
  `endingDate` datetime NOT NULL,
  `classId` int(11) NOT NULL,
  `groupId` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `examsinformation`
--

CREATE TABLE `examsinformation` (
  `ownerId` int(11) NOT NULL,
  `examId` int(11) NOT NULL,
  `examName` varchar(64) NOT NULL,
  `description` text NOT NULL,
  `requiredPermissionLevel` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `examsinformation`
--

INSERT INTO `examsinformation` (`ownerId`, `examId`, `examName`, `description`, `requiredPermissionLevel`) VALUES
(1, 1, 'bandittobambik examin', 'egzamin', 2),
(1, 8, 'imie', 'nazwa', 2),
(4, 9, 'Inf03', 'egzamin inf03', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `studentscredentials`
--

CREATE TABLE `studentscredentials` (
  `ID` int(11) NOT NULL,
  `login` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` tinytext NOT NULL,
  `surname` tinytext NOT NULL,
  `class` varchar(64) NOT NULL,
  `classgroup` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Dumping data for table `studentscredentials`
--

INSERT INTO `studentscredentials` (`ID`, `login`, `password`, `name`, `surname`, `class`, `classgroup`) VALUES
(1, 'ejt', 'asit', 'Tymon', 'Ławniczak', '3TP', 2),
(2, 'test', 'test13', 'test', 'test', '3TP', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `credentials`
--
ALTER TABLE `credentials`
  ADD PRIMARY KEY (`ID`);

--
-- Indeksy dla tabeli `examsinformation`
--
ALTER TABLE `examsinformation`
  ADD PRIMARY KEY (`examId`);

--
-- Indeksy dla tabeli `studentscredentials`
--
ALTER TABLE `studentscredentials`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `credentials`
--
ALTER TABLE `credentials`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `examsinformation`
--
ALTER TABLE `examsinformation`
  MODIFY `examId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `studentscredentials`
--
ALTER TABLE `studentscredentials`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
