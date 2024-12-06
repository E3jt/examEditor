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
-- Database: `exams`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `1`
--

CREATE TABLE `1` (
  `id` int(11) NOT NULL,
  `answerId` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `text` varchar(512) NOT NULL,
  `correct` tinyint(1) NOT NULL,
  `resource` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `1`
--

INSERT INTO `1` (`id`, `answerId`, `type`, `text`, `correct`, `resource`) VALUES
(1, 0, 1, 'tresc', 0, ''),
(1, 1, 2, 'tresc', 1, ''),
(1, 2, 2, 'tresc zle', 0, ''),
(2, 1, 2, 'open', 0, ''),
(2, 0, 3, 'tresc otwartego', 0, '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `8`
--

CREATE TABLE `8` (
  `id` int(11) NOT NULL,
  `answerId` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `text` varchar(512) NOT NULL,
  `correct` tinyint(1) NOT NULL,
  `resource` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `9`
--

CREATE TABLE `9` (
  `id` int(11) NOT NULL,
  `answerId` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `text` varchar(512) NOT NULL,
  `correct` tinyint(1) NOT NULL,
  `resource` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Dumping data for table `9`
--

INSERT INTO `9` (`id`, `answerId`, `type`, `text`, `correct`, `resource`) VALUES
(1, 0, 1, 'Skrypt php jest wykonywany po stronie :', 0, ''),
(2, 0, 1, 'W języku php iloczyn logiczny jest oznaczany za pomocą operatora :', 0, ''),
(1, 1, 2, 'Klienta', 0, ''),
(1, 2, 2, 'serwera', 1, ''),
(1, 3, 2, 'zależnie od ustawień systemu', 0, ''),
(2, 1, 2, 'OR', 0, ''),
(2, 2, 2, '||', 0, ''),
(2, 3, 2, 'AND', 1, ''),
(2, 4, 2, '&&', 1, '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
