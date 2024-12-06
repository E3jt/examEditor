-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2024 at 08:14 AM
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
-- Database: `answers`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `1`
--

CREATE TABLE `1` (
  `userid` int(11) NOT NULL,
  `questionID` int(11) NOT NULL,
  `answerID` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `content` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `1`
--

INSERT INTO `1` (`userid`, `questionID`, `answerID`, `type`, `content`) VALUES
(1, 1, 1, 0, ''),
(1, 2, 1, 1, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `8`
--

CREATE TABLE `8` (
  `userid` int(11) NOT NULL,
  `questionID` int(11) NOT NULL,
  `answerID` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `content` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `9`
--

CREATE TABLE `9` (
  `userid` int(11) NOT NULL,
  `questionID` int(11) NOT NULL,
  `answerID` int(11) NOT NULL,
  `type` int(1) NOT NULL,
  `content` varchar(2048) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `9`
--

INSERT INTO `9` (`userid`, `questionID`, `answerID`, `type`, `content`) VALUES
(2, 1, 2, 0, ''),
(2, 2, 3, 0, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `completed`
--

CREATE TABLE `completed` (
  `userID` int(11) NOT NULL,
  `examId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `completed`
--

INSERT INTO `completed` (`userID`, `examId`) VALUES
(1, 1),
(2, 9);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
