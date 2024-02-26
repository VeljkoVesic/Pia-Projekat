-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 26, 2024 at 08:44 PM
-- Server version: 8.2.0
-- PHP Version: 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reglog`
--

-- --------------------------------------------------------

--
-- Table structure for table `firma`
--

DROP TABLE IF EXISTS `firma`;
CREATE TABLE IF NOT EXISTS `firma` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ime_firme` varchar(50) NOT NULL DEFAULT 'Privatno',
  `vlasnik` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `firma`
--

INSERT INTO `firma` (`id`, `ime_firme`, `vlasnik`) VALUES
(3, 'Sample1', 21),
(4, 'Sample2', 17),
(5, 'Sample3', 16),
(6, 'Sample4', 20);

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

DROP TABLE IF EXISTS `komentar`;
CREATE TABLE IF NOT EXISTS `komentar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sadrzaj` varchar(100) NOT NULL,
  `ocena` int NOT NULL,
  `kandidat` int NOT NULL,
  `poslodavac` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `komentar`
--

INSERT INTO `komentar` (`id`, `sadrzaj`, `ocena`, `kandidat`, `poslodavac`) VALUES
(20, 'Nikakva firma, nisu mi ni pregledali oglas!', 1, 22, 21),
(19, 'Definitivno dobro radno iskustvo, mada nije firma za svaÄije Å¾ivce!', 3, 15, 21);

-- --------------------------------------------------------

--
-- Table structure for table `oglasi`
--

DROP TABLE IF EXISTS `oglasi`;
CREATE TABLE IF NOT EXISTS `oglasi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `naslov` varchar(50) NOT NULL,
  `lokacija` varchar(50) NOT NULL,
  `sprema` varchar(50) NOT NULL,
  `opis` varchar(200) NOT NULL,
  `rok` varchar(15) NOT NULL,
  `poslodavac` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `oglasi`
--

INSERT INTO `oglasi` (`id`, `naslov`, `lokacija`, `sprema`, `opis`, `rok`, `poslodavac`) VALUES
(34, 'Junior Python Programmer', 'Beograd', 'Diploma fakulteta ili sertifikat', 'TraÅ¾imo Junior python developer-a za naÅ¡ tim! Ako imate iskustva sa Python-om i Å¾elite se razvijati u karijeri programera, slobodno se prijavite na naÅ¡ oglas.', '30.04.2023.', '21'),
(35, 'Radnik na kasi ', 'Kragujevac', 'Srednja Å¡kola', 'TraÅ¾imo energiÄnog i motiviranog radnika na kasi i buzzera za naÅ¡ tim! Ako Å¾elite raditi u dinamiÄnom okruÅ¾enju i imate iskustva u radu na kasi, slobodno se prijavite na naÅ¡ oglas.', '06.08.2023.', '17'),
(36, 'Senior JavaScript Programer', 'Kragujevac', 'Diploma fakulteta', 'Potrebni su nam entuzijastiÄni javascript programeri, prijavi se na naÅ¡ oglas i pokreni svoju karijeru!', '16.03.2023.', '16'),
(37, 'Radnik u kuhinji', 'PriÅ¡tina', 'Srednja Å¡kola', 'We need staff!', '06.05.2023.', '20');

-- --------------------------------------------------------

--
-- Table structure for table `prijava`
--

DROP TABLE IF EXISTS `prijava`;
CREATE TABLE IF NOT EXISTS `prijava` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cv` varchar(250) NOT NULL,
  `datum_rodjenja` varchar(15) NOT NULL,
  `sprema` varchar(50) NOT NULL,
  `iskustvo` varchar(50) NOT NULL,
  `oglas` int NOT NULL,
  `kandidat` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `prijava`
--

INSERT INTO `prijava` (`id`, `cv`, `datum_rodjenja`, `sprema`, `iskustvo`, `oglas`, `kandidat`) VALUES
(15, 'Ja sam student FIN-a u Kragujevcu i jako bih voleo da postanem Älan vaÅ¡eg tima! PoloÅ¾io sam mnogo ispita vezanih za programiranje i mislim da bih vam jako znaÄio u timu!', '13.01.2002.', 'Srednja Å¡kola (trenutno 3. godina fakulteta).', 'Radio sam kao python programer u NASA.', 34, 15),
(16, 'Ja sam student FIN-a u Kragujevcu i jako bih voleo da postanem Älan vaÅ¡eg tima! PoloÅ¾io sam mnogo ispita vezanih za programiranje i mislim da bih vam jako znaÄio u timu!', '13.01.2002.', 'Diploma fakulteta', 'Radio sam kao python programer u NASA.', 36, 15),
(17, 'Ja sam nekadaÅ¡nji koÅ¡arkaÅ¡ Crvene Zvezde i mnogo drugih timova, ali sam ipak shvatio da je viÅ¡e novca u programiranju nego u koÅ¡arci...', '05.01.1988.', 'Srednja Å¡kola', 'KK Crvena Zvezda', 34, 22),
(18, 'Ja sam Izet iz Sarajeva i ne znam niÅ¡ta da radim!', '19.08.1945.', 'Srednja Å¡kola', 'Supermarket', 35, 19);

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

DROP TABLE IF EXISTS `tb_user`;
CREATE TABLE IF NOT EXISTS `tb_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `username` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(75) NOT NULL,
  `uloga` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `name`, `username`, `email`, `password`, `uloga`) VALUES
(21, 'Luka Vildoza', 'lukav', 'lukav@gmail.com', 'lukav', 2),
(3, 'admin', 'admin', 'admin@admin.com', 'admin', 3),
(16, 'Veljko Vesic', 'veljkov', 'veljkov@gmail.com', 'veljkov', 2),
(15, 'Danilo Radosavljevic', 'danilor', 'danilor@gmail.com', 'danilor', 1),
(17, 'Aleksandar Djordjevic', 'aleksandardj', 'adjordjevic@kg.ac.rs', 'aleksandardj', 2),
(18, 'Nemanja Bjelica', 'nemanjab', 'nemanjab@gmail.com', 'nemanjab', 1),
(19, 'Izet Fazlinovic', 'izetf', 'izetf@gmail.com', 'izetf', 1),
(20, 'Fakundo Kampaco', 'fakundok', 'fakundok@gmail.com', 'fakundo', 2),
(22, 'Miroslav Raduljica', 'miroslavr', 'miroslavr@gmail.com', 'miroslavr', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
