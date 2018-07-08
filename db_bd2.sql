-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Lip 2018, 14:44
-- Wersja serwera: 10.1.29-MariaDB
-- Wersja PHP: 7.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `db_bd2`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `archives`
--

CREATE TABLE `archives` (
  `id` int(11) NOT NULL,
  `idPerson` int(11) NOT NULL,
  `firstName` text COLLATE utf8_polish_ci NOT NULL,
  `surname` text COLLATE utf8_polish_ci NOT NULL,
  `idBook` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `idLend` int(11) NOT NULL,
  `dateOfLend` date NOT NULL,
  `dateOfReturn` date NOT NULL,
  `idCopy` int(11) NOT NULL,
  `conditionOfCopy` text COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `archives`
--

INSERT INTO `archives` (`id`, `idPerson`, `firstName`, `surname`, `idBook`, `title`, `idLend`, `dateOfLend`, `dateOfReturn`, `idCopy`, `conditionOfCopy`) VALUES
(45, 1, 'Norbert', 'Malecki', 24, 'Iliada', 49, '2017-12-19', '2017-12-19', 11, 'nowa'),
(46, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 50, '2017-12-19', '2017-12-19', 3, 'nowa'),
(47, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 52, '2017-12-19', '2017-12-19', 3, 'nowa'),
(48, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 53, '2017-12-19', '2017-12-19', 3, 'nowa'),
(49, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 54, '2017-12-19', '2017-12-19', 3, 'nowa'),
(50, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 55, '2017-12-19', '2017-12-19', 3, 'nowa'),
(51, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 56, '2017-12-19', '2017-12-19', 3, 'nowa'),
(52, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 57, '2017-12-11', '2017-12-20', 3, 'nowa'),
(53, 1, 'Norbert', 'Malecki', 24, 'Iliada', 58, '2017-12-20', '2018-01-14', 11, 'nowa'),
(54, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 59, '2018-01-14', '2018-01-14', 3, 'nowa'),
(55, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 62, '2018-01-14', '2018-01-14', 3, 'nowa'),
(56, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 63, '2018-01-14', '2018-01-14', 3, 'nowa'),
(57, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 64, '2018-01-14', '2018-01-14', 3, 'nowa'),
(58, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 65, '2018-01-14', '2018-01-14', 3, 'nowa'),
(59, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 66, '2018-01-14', '2018-01-14', 3, 'nowa'),
(60, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 1, '2018-01-15', '2018-01-15', 3, 'nowa'),
(61, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 2, '2018-01-15', '2018-01-15', 3, 'nowa'),
(62, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 3, '2018-01-15', '2018-01-15', 3, 'nowa'),
(63, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 4, '2018-01-15', '2018-01-15', 3, 'nowa'),
(64, 1, 'Norbert', 'Malecki', 24, 'Iliada', 5, '2018-01-15', '2018-01-15', 11, 'nowa'),
(65, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 6, '2018-01-15', '2018-01-15', 3, 'nowa'),
(66, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 1, '2018-01-19', '2018-01-19', 3, 'nowa'),
(67, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 2, '2018-01-19', '2018-01-19', 3, 'nowa'),
(68, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 3, '2018-01-19', '2018-01-19', 3, 'nowa'),
(69, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 4, '2018-01-19', '2018-01-19', 3, 'nowa'),
(70, 1, 'Norbert', 'Malecki', 25, 'Potop', 5, '2018-01-19', '2018-01-19', 12, 'nowa'),
(71, 1, 'Norbert', 'Malecki', 27, 'Antygona', 6, '2018-01-19', '2018-01-19', 14, 'nowa'),
(72, 1, 'Norbert', 'Malecki', 24, 'Iliada', 7, '2018-01-19', '2018-01-19', 11, 'nowa'),
(73, 1, 'Norbert', 'Malecki', 25, 'Potop', 8, '2018-01-19', '2018-01-19', 12, 'nowa'),
(74, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 9, '2018-01-19', '2018-01-19', 3, 'nowa'),
(75, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 10, '2018-01-19', '2018-01-19', 3, 'nowa'),
(76, 1, 'Norbert', 'Malecki', 24, 'Iliada', 11, '2018-01-19', '2018-01-19', 11, 'nowa'),
(77, 1, 'Norbert', 'Malecki', 26, 'Ogniem i mieczem', 14, '2018-01-19', '2018-01-19', 13, 'nowa'),
(78, 1, 'Norbert', 'Malecki', 25, 'Potop', 13, '2018-01-19', '2018-01-19', 12, 'nowa'),
(79, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 12, '2018-01-19', '2018-01-19', 3, 'nowa'),
(80, 1, 'Norbert', 'Malecki', 27, 'Antygona', 15, '2018-01-19', '2018-01-19', 14, 'nowa'),
(81, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 16, '2018-01-19', '2018-01-19', 3, 'nowa'),
(82, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 17, '2018-01-19', '2018-01-19', 3, 'nowa'),
(83, 2, 'Przegryw', 'Zyciowy', 2, 'Pan Tadeusz', 18, '2018-01-19', '2018-01-19', 3, 'nowa'),
(84, 2, 'Przegryw', 'Zyciowy', 2, 'Pan Tadeusz', 19, '2018-01-19', '2018-01-19', 3, 'nowa'),
(85, 1, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 20, '2018-01-20', '2018-01-20', 3, 'nowa'),
(86, 4, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 21, '2018-01-20', '2018-01-20', 3, 'nowa'),
(87, 4, 'Norbert', 'Malecki', 24, 'Iliada', 22, '2018-01-20', '2018-01-20', 11, 'nowa'),
(88, 4, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 23, '2018-01-20', '2018-01-20', 3, 'nowa'),
(89, 4, 'Norbert', 'Malecki', 27, 'Antygona', 24, '2018-01-20', '2018-01-20', 14, 'nowa'),
(90, 4, 'Norbert', 'Malecki', 24, 'Iliada', 25, '2018-01-20', '2018-01-20', 11, 'nowa'),
(91, 4, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 26, '2018-01-20', '2018-01-20', 3, 'nowa'),
(92, 4, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 1, '2018-01-20', '2018-01-21', 3, 'nowa'),
(93, 4, 'Norbert', 'Malecki', 27, 'Antygona', 2, '2018-01-20', '2018-01-21', 14, 'nowa'),
(94, 4, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 3, '2018-01-21', '2018-01-21', 3, 'nowa'),
(95, 4, 'Norbert', 'Malecki', 26, 'Ogniem i mieczem', 4, '2018-01-21', '2018-01-21', 13, 'nowa'),
(96, 4, 'Norbert', 'Malecki', 26, 'Ogniem i mieczem', 5, '2018-01-21', '2018-01-21', 13, 'nowa'),
(97, 4, 'Norbert', 'Malecki', 26, 'Ogniem i mieczem', 6, '2018-01-21', '2018-01-21', 13, 'nowa'),
(98, 4, 'Norbert', 'Malecki', 25, 'Potop', 7, '2018-01-21', '2018-01-21', 12, 'nowa'),
(99, 4, 'Norbert', 'Malecki', 24, 'Iliada', 8, '2018-01-21', '2018-01-21', 11, 'nowa'),
(100, 4, 'Norbert', 'Malecki', 27, 'Antygona', 9, '2018-01-21', '2018-01-21', 14, 'nowa'),
(101, 4, 'Norbert', 'Malecki', 27, 'Antygona', 10, '2018-01-21', '2018-01-21', 14, 'nowa'),
(102, 4, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 11, '2018-01-21', '2018-01-21', 3, 'nowa'),
(103, 4, 'Norbert', 'Malecki', 25, 'Potop', 12, '2018-01-21', '2018-01-21', 12, 'nowa'),
(104, 4, 'Norbert', 'Malecki', 24, 'Iliada', 13, '2018-01-21', '2018-01-21', 11, 'nowa'),
(105, 4, 'Norbert', 'Malecki', 26, 'Ogniem i mieczem', 14, '2018-01-21', '2018-01-21', 13, 'nowa'),
(106, 4, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 15, '2018-01-21', '2018-01-21', 3, 'nowa'),
(107, 4, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 16, '2018-01-21', '2018-01-21', 3, 'nowa'),
(108, 4, 'Norbert', 'Malecki', 25, 'Potop', 17, '2018-01-21', '2018-01-21', 12, 'nowa'),
(109, 4, 'Norbert', 'Malecki', 27, 'Antygona', 18, '2018-01-21', '2018-01-21', 14, 'nowa'),
(110, 4, 'Norbert', 'Malecki', 2, 'Pan Tadeusz', 19, '2018-01-21', '2018-01-21', 3, 'nowa'),
(111, 6, 'Jeremiasz', 'Romejko', 2, 'Pan Tadeusz', 21, '2018-01-23', '2018-01-23', 3, 'nowa'),
(112, 6, 'Jeremiasz', 'Romejko', 2, 'Pan Tadeusz', 22, '2018-01-23', '2018-01-23', 3, 'nowa'),
(113, 7, 'sabina', 'Jewticz', 2, 'Pan Tadeusz', 21, '2018-01-24', '2018-01-24', 3, 'nowa'),
(114, 6, 'Jeremiasz', 'Romejko', 30, 'Mroczna WieÅ¼a', 22, '2018-01-24', '2018-01-24', 17, 'nowa'),
(115, 6, 'Jeremiasz', 'Romejko', 30, 'Mroczna WieÅ¼a', 23, '2018-01-24', '2018-01-24', 17, 'nowa'),
(116, 8, 'Jagoda', 'Romejko', 2, 'Pan Tadeusz', 22, '2018-02-11', '2018-02-11', 3, 'nowa'),
(117, 8, 'Jagoda', 'Romejko', 30, 'Mroczna WieÅ¼a', 21, '2018-02-11', '2018-02-11', 17, 'nowa'),
(118, 6, 'Jeremiasz', 'Romejko', 30, 'Mroczna WieÅ¼a', 21, '2018-02-15', '2018-02-15', 17, 'nowa'),
(119, 6, 'Jeremiasz', 'Romejko', 2, 'Pan Tadeusz', 21, '2018-04-04', '2018-04-04', 3, 'nowa'),
(120, 6, 'Jeremiasz', 'Romejko', 30, 'Mroczna WieÅ¼a', 22, '2018-04-04', '2018-04-04', 17, 'nowa'),
(121, 6, 'Jeremiasz', 'Romejko', 2, 'Pan Tadeusz', 1, '2018-07-08', '2018-07-08', 3, 'nowa');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `book`
--

CREATE TABLE `book` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_polish_ci NOT NULL,
  `author` text COLLATE utf8_polish_ci NOT NULL,
  `amountOfAvailable` int(11) NOT NULL,
  `amountOfAll` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `book`
--

INSERT INTO `book` (`id`, `title`, `author`, `amountOfAvailable`, `amountOfAll`) VALUES
(2, 'Pan Tadeusz', 'Adam Mickiewicz', 15, 19),
(24, 'Iliada', 'Homer', 10, 10),
(25, 'Potop', 'Henryk Sienkiewicz', 10, 10),
(26, 'Ogniem i mieczem', 'Henryk Sienkiewicz', 10, 10),
(27, 'Antygona', 'Sofokles', 10, 10),
(29, 'Balladyna', 'Juliusz SÅ‚owacki', 10, 10),
(30, 'Mroczna WieÅ¼a', 'Stephen King', 20, 20);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `copy_book`
--

CREATE TABLE `copy_book` (
  `id` int(11) NOT NULL,
  `publishingHouse` text COLLATE utf8_polish_ci NOT NULL,
  `conditionOfCopy` text COLLATE utf8_polish_ci NOT NULL,
  `publicationDate` int(11) NOT NULL,
  `idBook` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `copy_book`
--

INSERT INTO `copy_book` (`id`, `publishingHouse`, `conditionOfCopy`, `publicationDate`, `idBook`) VALUES
(3, 'Greg', 'nowa', 2002, 2),
(11, 'Greg', 'nowa', 2004, 24),
(12, 'Greg', 'nowa', 2018, 25),
(13, 'Greg', 'nowa', 1998, 26),
(14, 'Greg', 'nowa', 2003, 27),
(16, 'Greg', 'nowa', 2005, 29),
(17, 'ska', 'nowa', 2015, 30);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lend`
--

CREATE TABLE `lend` (
  `id` int(11) NOT NULL,
  `idPerson` int(11) NOT NULL,
  `idBook` int(11) NOT NULL,
  `dateOfLend` date NOT NULL,
  `dateOfReturn` date NOT NULL,
  `extendedDateOfReturn` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `lista`
--

CREATE TABLE `lista` (
  `lista` multipoint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `person`
--

CREATE TABLE `person` (
  `id` int(11) NOT NULL,
  `login` text COLLATE utf8_polish_ci NOT NULL,
  `email` text COLLATE utf8_polish_ci NOT NULL,
  `password` text COLLATE utf8_polish_ci NOT NULL,
  `firstName` text COLLATE utf8_polish_ci NOT NULL,
  `surname` text COLLATE utf8_polish_ci NOT NULL,
  `amountOfRented` int(11) NOT NULL,
  `admin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `person`
--

INSERT INTO `person` (`id`, `login`, `email`, `password`, `firstName`, `surname`, `amountOfRented`, `admin`) VALUES
(3, 'test', 'test@gmail.com', '$2y$10$MH04Wi/r/Aw95TIGxwcGt.cMBtc8zfaJFoMsRThRDUGxSMJiSO4Oa', 'testowy', 'norbert', 0, 0),
(6, 'romeo8982', 'romeo8982@gmail.com', '$2y$10$CKjRAVEEbhSnOzLEAwTaluOyJOK9L5tF1odQ3cfgUhA5.4rrGeWrW', 'Jeremiasz', 'Romejko', 0, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `idPerson` (`idPerson`),
  ADD KEY `idBook` (`idBook`),
  ADD KEY `idCopy` (`idCopy`),
  ADD KEY `idLend` (`idLend`);

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `copy_book`
--
ALTER TABLE `copy_book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `idBook` (`idBook`);

--
-- Indexes for table `lend`
--
ALTER TABLE `lend`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `idPerson` (`idPerson`),
  ADD KEY `idBook` (`idBook`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `archives`
--
ALTER TABLE `archives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT dla tabeli `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT dla tabeli `copy_book`
--
ALTER TABLE `copy_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `lend`
--
ALTER TABLE `lend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `archives`
--
ALTER TABLE `archives`
  ADD CONSTRAINT `archives_ibfk_2` FOREIGN KEY (`idBook`) REFERENCES `book` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `archives_ibfk_3` FOREIGN KEY (`idCopy`) REFERENCES `copy_book` (`id`) ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `copy_book`
--
ALTER TABLE `copy_book`
  ADD CONSTRAINT `copy_book_ibfk_1` FOREIGN KEY (`idBook`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ograniczenia dla tabeli `lend`
--
ALTER TABLE `lend`
  ADD CONSTRAINT `lend_ibfk_1` FOREIGN KEY (`idBook`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lend_ibfk_2` FOREIGN KEY (`idPerson`) REFERENCES `person` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `lend_ibfk_3` FOREIGN KEY (`idBook`) REFERENCES `book` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
