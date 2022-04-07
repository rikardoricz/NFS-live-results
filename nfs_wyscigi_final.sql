-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 07 Kwi 2022, 02:11
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `nfs_wyscigi`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `gracze`
--

CREATE TABLE `gracze` (
  `id_g` int(11) NOT NULL,
  `imie` varchar(20) NOT NULL,
  `nazwisko` varchar(30) NOT NULL,
  `nr_stanowiska` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `gracze`
--

INSERT INTO `gracze` (`id_g`, `imie`, `nazwisko`, `nr_stanowiska`) VALUES
(1, 'Marcin', 'Bracha', 1),
(2, 'Szymon', 'Szewczyk', 4),
(3, 'Dawid', 'Wieczorek', 5),
(4, 'Adam', 'Zdziłowski', 6),
(5, 'Michal', 'Ostenda', 7),
(6, 'Tomek', 'Swiatek', 8),
(7, 'Jan', 'Siwek', 9),
(8, 'Mateusz', 'Urbaniak', 10),
(9, 'Szymon', 'Sadziński', 11),
(10, 'Piotr', 'Wdowiński', 12),
(11, 'Błażej', 'Śnieg', 13),
(12, 'Wiktor', 'Zemła', 14),
(13, 'Krzysztof', 'Prorok', 15),
(14, 'Wiktor', 'Niewiadomski', 16),
(15, 'Wiktor', 'Nowicki', 17),
(16, 'Mateusz', 'Urbaniak', 18);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mapy`
--

CREATE TABLE `mapy` (
  `id_m` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL,
  `id_t` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `mapy`
--

INSERT INTO `mapy` (`id_m`, `nazwa`, `id_t`) VALUES
(1, 'Resort Loop', 1),
(2, 'Outer Ring', 1),
(3, 'Freemont', 1),
(4, 'Providencia', 1),
(5, 'Lower Eastside', 1),
(6, 'City Hall', 1),
(7, 'Switchback', 1),
(8, 'Palm Highway', 1),
(9, 'Bellavista', 1),
(10, 'Bayview Summit', 1),
(11, 'Shoreside', 1),
(12, 'Ambassador Ridge', 1),
(13, 'Freeway West', 1),
(14, 'University Hill', 1),
(15, 'Observatory', 1),
(16, 'Freeway East', 1),
(17, 'Marine & 25th', 1),
(18, 'Dockside', 1),
(19, 'Boxcar', 1),
(20, 'Smokestack', 1),
(21, 'Bayview Concrete', 1),
(22, 'Grandview Station', 1),
(23, 'Jackpot', 1),
(24, 'Woodbine Park', 1),
(25, 'Park Drive', 1),
(26, '12th & Arbutus', 1),
(27, 'Bayview International', 1),
(28, 'Garibaldi Run', 1),
(29, 'Broad Street', 1),
(30, 'Scenic Ride', 1),
(31, 'Phoenix Steel', 1),
(32, 'Wall Center', 2),
(33, 'Palomino & 16th', 2),
(34, 'Bayview Plaza', 2),
(35, 'Rockridge Cross', 2),
(36, 'South Junction', 2),
(37, 'Upper Deck', 2),
(38, 'Grouse Grind', 2),
(39, 'Palm Hill', 2),
(40, 'Tailgate', 2),
(41, 'Rollercoaster', 2),
(42, 'Sentinel Hill', 2),
(43, 'Eagleridge Estates', 2),
(44, 'The Chief', 2),
(45, 'Blackcomb Way', 2),
(46, 'Cypress Bowl', 2),
(47, 'Terminal & 2nd', 2),
(48, 'Port Authority', 2),
(49, 'Waste Management', 2),
(50, 'Domestic Arrivals', 2),
(51, 'Broadway & Granville', 2),
(52, 'Black Tusk', 2),
(53, '2nd & Bellevue', 2),
(54, 'Marathon', 2),
(55, 'Bayview Bridge', 3),
(56, 'Tunnel Construction', 3),
(57, 'North Freeway', 3),
(58, 'Coastal Express', 3),
(59, 'Switching Yard', 3),
(60, 'South Runway', 3),
(61, 'Runway 15', 3),
(62, 'Runway 9', 3),
(63, 'Airport Freeway', 3),
(64, 'Central Station', 3),
(65, 'Stadium Drift 2', 4),
(66, 'Capilano Heights', 4),
(67, 'Stadium Drift 1', 4),
(68, 'Stadium Drift 3', 4),
(69, 'Stadium Drift 4', 4),
(70, 'Stadium Drift 5', 4),
(71, 'Parkade Drift 1', 4),
(72, 'Parkade Drift 2', 4),
(73, 'Parkade Drift 3', 4),
(74, 'Parkade Drift 4', 4),
(75, 'Parkade Drift 5', 4),
(76, 'Parkade Drift 6', 4),
(77, 'Hillside Manor', 4),
(78, 'Powerline', 4),
(79, 'Hollyburn Ridge', 4),
(80, 'Lighthouse', 4),
(81, 'City Lights', 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `tryby`
--

CREATE TABLE `tryby` (
  `id_t` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `tryby`
--

INSERT INTO `tryby` (`id_t`, `nazwa`) VALUES
(1, 'tor'),
(2, 'sprint'),
(3, 'drag'),
(4, 'drift');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id_u` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `haslo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id_u`, `login`, `haslo`) VALUES
(1, 'admin', '7110eda4d09e062aa5e4a390b0a572ac0d2c0220'),
(2, 'user', '4347d0f8ba661234a8eadc005e2e1d1b646c9682');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wyscigi`
--

CREATE TABLE `wyscigi` (
  `id_w` int(11) NOT NULL,
  `id_t` int(11) DEFAULT NULL,
  `id_m` int(11) DEFAULT NULL,
  `punkty` int(11) DEFAULT NULL,
  `czas` time(6) DEFAULT NULL,
  `id_g` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `wyscigi`
--

INSERT INTO `wyscigi` (`id_w`, `id_t`, `id_m`, `punkty`, `czas`, `id_g`) VALUES
(2, 3, 3, 0, '03:33:33.022000', 4),
(3, 4, 4, 33334, '00:00:00.000000', 10),
(4, 3, 3, 0, '03:34:05.055000', 4),
(6, 2, 2, 0, '03:03:04.006000', 8),
(7, 4, 4, 410000, '00:00:00.000000', 6),
(66, 2, 36, 0, '06:06:06.666000', 4),
(67, 4, NULL, 7, '00:00:00.000000', 3),
(68, 4, NULL, 7, '00:00:00.000000', 3),
(69, 4, NULL, 7, '00:00:00.000000', 3),
(70, 1, 3, 0, '03:33:33.033000', 2);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `gracze`
--
ALTER TABLE `gracze`
  ADD PRIMARY KEY (`id_g`);

--
-- Indeksy dla tabeli `mapy`
--
ALTER TABLE `mapy`
  ADD PRIMARY KEY (`id_m`);

--
-- Indeksy dla tabeli `tryby`
--
ALTER TABLE `tryby`
  ADD PRIMARY KEY (`id_t`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id_u`);

--
-- Indeksy dla tabeli `wyscigi`
--
ALTER TABLE `wyscigi`
  ADD PRIMARY KEY (`id_w`),
  ADD KEY `id_t` (`id_t`),
  ADD KEY `id_m` (`id_m`),
  ADD KEY `id_g` (`id_g`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `gracze`
--
ALTER TABLE `gracze`
  MODIFY `id_g` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT dla tabeli `mapy`
--
ALTER TABLE `mapy`
  MODIFY `id_m` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT dla tabeli `tryby`
--
ALTER TABLE `tryby`
  MODIFY `id_t` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id_u` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `wyscigi`
--
ALTER TABLE `wyscigi`
  MODIFY `id_w` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `wyscigi`
--
ALTER TABLE `wyscigi`
  ADD CONSTRAINT `id_g` FOREIGN KEY (`id_g`) REFERENCES `gracze` (`id_g`),
  ADD CONSTRAINT `id_m` FOREIGN KEY (`id_m`) REFERENCES `mapy` (`id_m`),
  ADD CONSTRAINT `id_t` FOREIGN KEY (`id_t`) REFERENCES `tryby` (`id_t`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
