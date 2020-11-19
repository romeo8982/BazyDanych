-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 19 Lis 2020, 11:41
-- Wersja serwera: 10.4.14-MariaDB
-- Wersja PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
(120, 6, 'Jeremiasz', 'Romejko', 30, 'Mroczna Wieża', 22, '2018-04-04', '2018-04-04', 17, 'nowa'),
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
(2, 'Pan Tadeusz', 'Adam Mickiewicz', 14, 19),
(30, 'Mroczna Wieża', 'Stephen King', 19, 20),
(31, 'Lsnienie', 'Stephen King', 15, 15);

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
(17, 'ska', 'nowa', 2015, 30),
(18, 'ska', 'nowa', 1986, 31);

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

--
-- Zrzut danych tabeli `lend`
--

INSERT INTO `lend` (`id`, `idPerson`, `idBook`, `dateOfLend`, `dateOfReturn`, `extendedDateOfReturn`) VALUES
(5, 10, 30, '2020-11-19', '2020-12-19', 0),
(6, 10, 2, '2020-11-19', '2020-12-19', 0);

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
(6, 'romeo8982', 'romeo8982@gmail.com', '$2y$10$CKjRAVEEbhSnOzLEAwTaluOyJOK9L5tF1odQ3cfgUhA5.4rrGeWrW', 'Jeremiasz', 'Romejko', 1, 1),
(10, 'Jan', 'jan.kowalski@gmail.com', '$2y$10$uBQlqj0CG8mtCMxtY3kph.lAZ5R85up7sTg48L3HxtgB/E9H7HmUK', 'Jan', 'Kowalski', 2, 0);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `archives`
--
ALTER TABLE `archives`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `idPerson` (`idPerson`),
  ADD KEY `idBook` (`idBook`),
  ADD KEY `idCopy` (`idCopy`),
  ADD KEY `idLend` (`idLend`);

--
-- Indeksy dla tabeli `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indeksy dla tabeli `copy_book`
--
ALTER TABLE `copy_book`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `idBook` (`idBook`);

--
-- Indeksy dla tabeli `lend`
--
ALTER TABLE `lend`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `idPerson` (`idPerson`),
  ADD KEY `idBook` (`idBook`);

--
-- Indeksy dla tabeli `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `archives`
--
ALTER TABLE `archives`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=124;

--
-- AUTO_INCREMENT dla tabeli `book`
--
ALTER TABLE `book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT dla tabeli `copy_book`
--
ALTER TABLE `copy_book`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT dla tabeli `lend`
--
ALTER TABLE `lend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT dla tabeli `person`
--
ALTER TABLE `person`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
