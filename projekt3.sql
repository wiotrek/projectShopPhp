-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 01, 2020 at 11:42 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projekt3`
--

-- --------------------------------------------------------

--
-- Table structure for table `klienci`
--

CREATE TABLE `klienci` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `surname` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `klienci`
--

INSERT INTO `klienci` (`id`, `login`, `password`, `name`, `surname`) VALUES
(1, 'krzys123', 'abc', 'krzysztof', 'sulkowski'),
(2, 'jarek123', 'abcd', 'jaroslaw', 'gutowski'),
(3, 'da', 'dadadada', 'da', 'da'),
(4, 'bartek123', 'Kaczmi123', 'Bartek', 'Kaczmarek'),
(5, 'Czarek123', 'dupadupa', 'Czarek', 'Czarnecki');

-- --------------------------------------------------------

--
-- Table structure for table `produkty`
--

CREATE TABLE `produkty` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(25) NOT NULL,
  `opis` text DEFAULT NULL,
  `cena` decimal(6,2) NOT NULL,
  `kategoria` varchar(20) NOT NULL,
  `zdjecie` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `produkty`
--

INSERT INTO `produkty` (`id`, `nazwa`, `opis`, `cena`, `kategoria`, `zdjecie`) VALUES
(1, 'lewis', 'blablabla', '24.21', 'spodnie', 'spodnie.jpeg'),
(2, 'adidas', 'dobra koszulka polecam Michal Wisniewski', '81.00', 'koszulka', 'koszulka.jpeg');

-- --------------------------------------------------------

--
-- Stand-in structure for view `widok_zamowienia`
-- (See below for the actual view)
--
CREATE TABLE `widok_zamowienia` (
`id_klienta` int(11)
,`sum(cena_razem)` decimal(30,2)
);

-- --------------------------------------------------------

--
-- Table structure for table `zamowienia`
--

CREATE TABLE `zamowienia` (
  `id` int(11) UNSIGNED NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `id_produktu` int(11) NOT NULL,
  `ilosc` tinyint(3) UNSIGNED NOT NULL,
  `cena_za_szt` decimal(8,2) UNSIGNED NOT NULL,
  `cena_razem` decimal(8,2) UNSIGNED NOT NULL,
  `data` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zamowienia`
--

INSERT INTO `zamowienia` (`id`, `id_klienta`, `id_produktu`, `ilosc`, `cena_za_szt`, `cena_razem`, `data`) VALUES
(22, 2, 3, 4, '3.00', '3.00', '2020-07-01 08:31:36'),
(24, 1, 1, 1, '24.00', '24.00', '2020-07-01 08:33:25'),
(25, 1, 2, 3, '81.00', '243.00', '2020-07-01 09:08:07'),
(26, 1, 1, 2, '24.00', '48.00', '2020-07-01 09:35:12'),
(27, 2, 1, 2, '24.00', '48.00', '2020-07-01 09:37:45');

-- --------------------------------------------------------

--
-- Structure for view `widok_zamowienia`
--
DROP TABLE IF EXISTS `widok_zamowienia`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `widok_zamowienia`  AS  select `zamowienia`.`id_klienta` AS `id_klienta`,sum(`zamowienia`.`cena_razem`) AS `sum(cena_razem)` from `zamowienia` group by `zamowienia`.`id_klienta` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `klienci`
--
ALTER TABLE `klienci`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produkty`
--
ALTER TABLE `produkty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_klienta` (`id_klienta`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `klienci`
--
ALTER TABLE `klienci`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `produkty`
--
ALTER TABLE `produkty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `zamowienia`
--
ALTER TABLE `zamowienia`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `zamowienia`
--
ALTER TABLE `zamowienia`
  ADD CONSTRAINT `zamowienia_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `klienci` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
