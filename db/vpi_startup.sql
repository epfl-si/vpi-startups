-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Apr 27, 2021 at 07:21 AM
-- Server version: 10.5.9-MariaDB-1:10.5.9+maria~focal
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vpi_startup`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id_category` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id_category`, `category`) VALUES
(1, 'EPFL Startup'),
(2, 'EPFL Launchpad'),
(3, 'EIP Company');

-- --------------------------------------------------------

--
-- Table structure for table `ceo_education_level`
--

CREATE TABLE `ceo_education_level` (
  `id_ceo_education_level` int(11) NOT NULL,
  `ceo_education_level` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ceo_education_level`
--

INSERT INTO `ceo_education_level` (`id_ceo_education_level`, `ceo_education_level`) VALUES
(1, 'Bachelor'),
(2, 'Master'),
(3, 'PhD'),
(4, 'Formation continue'),
(5, 'Autre');

-- --------------------------------------------------------

--
-- Stand-in structure for view `detail_startup`
-- (See below for the actual view)
--
CREATE TABLE `detail_startup` (
`id_startup` int(11)
,`company` varchar(255)
,`web` varchar(255)
,`founding_date` varchar(4)
,`rc` varchar(255)
,`exit_year` varchar(4)
,`epfl_grant` varchar(255)
,`awards_competitions` varchar(255)
,`laboratory` varchar(30)
,`short_description` varchar(255)
,`status` varchar(255)
,`type_startup` varchar(30)
,`sectors` varchar(30)
,`category` varchar(255)
,`ceo_education_level` varchar(30)
,`country` mediumtext
,`impact` mediumtext
);

-- --------------------------------------------------------

--
-- Table structure for table `faculty_schools`
--

CREATE TABLE `faculty_schools` (
  `id_faculty_schools` int(11) NOT NULL,
  `faculty_schools` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `faculty_schools`
--

INSERT INTO `faculty_schools` (`id_faculty_schools`, `faculty_schools`) VALUES
(1, 'ENAC'),
(2, 'IC'),
(3, 'SB'),
(4, 'STI'),
(5, 'SV'),
(6, 'CDH'),
(7, 'CDM'),
(8, 'Antenna'),
(9, 'Others');

-- --------------------------------------------------------

--
-- Table structure for table `founders_country`
--

CREATE TABLE `founders_country` (
  `id_founders_country` int(11) NOT NULL,
  `founders_country` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `founders_country`
--

INSERT INTO `founders_country` (`id_founders_country`, `founders_country`) VALUES
(1, 'Switzerland'),
(2, 'Italy'),
(3, 'USA'),
(4, 'Japan'),
(5, 'Germany'),
(6, 'Russia'),
(7, 'Canada'),
(8, 'Denmark'),
(9, 'France'),
(10, 'Austria'),
(11, 'South Africa'),
(12, 'Argentina'),
(13, 'Poland'),
(14, 'Greece'),
(15, 'India'),
(16, 'Netherlands'),
(17, 'Brazil'),
(18, 'Romania'),
(19, 'Czech Republic'),
(20, 'Spain'),
(21, 'Iran'),
(22, 'Sweden'),
(23, 'United Kingdom'),
(24, 'Marocco');

-- --------------------------------------------------------

--
-- Table structure for table `funding`
--

CREATE TABLE `funding` (
  `id_funding` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `investment_date` date DEFAULT NULL,
  `investors` varchar(30) DEFAULT NULL,
  `fk_stage_of_investment` int(11) DEFAULT NULL,
  `fk_type_of_investment` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `funding`
--

INSERT INTO `funding` (`id_funding`, `amount`, `investment_date`, `investors`, `fk_stage_of_investment`, `fk_type_of_investment`) VALUES
(1, '2000000', '2020-01-25', NULL, 2, 2),
(2, '20000', '2021-02-04', 'FIT', 7, 3),
(3, '2000000', '2021-02-17', 'Hugo', 3, 5),
(4, '2000000', '2020-01-25', '', 2, 2),
(5, '20000', '2021-02-04', 'FIT', 7, 3),
(6, '2000000', '2021-02-17', 'Hugo', 3, 5),
(7, '10000', '2021-01-12', '', 1, 1);

-- --------------------------------------------------------

--
-- Stand-in structure for view `funds_by_sector`
-- (See below for the actual view)
--
CREATE TABLE `funds_by_sector` (
`sectors` varchar(30)
,`amount` double
);

-- --------------------------------------------------------

--
-- Table structure for table `impact_sdg`
--

CREATE TABLE `impact_sdg` (
  `id_impact_sdg` int(11) NOT NULL,
  `impact_sdg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `impact_sdg`
--

INSERT INTO `impact_sdg` (`id_impact_sdg`, `impact_sdg`) VALUES
(1, 'Pas de pauvreté'),
(2, 'Faim Zéro'),
(3, 'Bonne santé et bien-être'),
(4, 'Éducation de qualité'),
(5, 'Égalité entre les sexes'),
(6, 'Eau propre et assainissement'),
(7, 'Énergie propre et d\'un coût abordable'),
(8, 'Travail décent et croissance économique'),
(9, 'Industrie, innovation et infrastructure'),
(10, 'Inégalités réduites'),
(11, 'Villes et communautés durable'),
(12, 'Consommation et production responsables'),
(13, 'Mesures relatives à la lutte contre les changements climatiques'),
(14, 'Vie aquatique'),
(15, 'Vie terrestre'),
(16, 'Paix, justice et institutions efficaces'),
(17, 'Partenariats pour la réalisation des objectifs');

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `id_person` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `person_function` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `prof_as_founder` tinyint(1) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `fk_type_of_person` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`id_person`, `name`, `firstname`, `person_function`, `email`, `prof_as_founder`, `gender`, `fk_type_of_person`) VALUES
(12, 'Kobler', 'Christian', NULL, NULL, 0, 0, 4),
(13, 'Clavel', NULL, NULL, NULL, 1, 0, 6),
(14, 'Lasser/Renaud', NULL, NULL, NULL, 0, 0, 6),
(15, 'Durand', 'Nicolas', NULL, 'nicolas.durand@abionic.com', 0, 1, 4),
(16, 'Clavel', '', '', '', 1, 0, 6),
(17, 'Durand', 'Nicolas', '', 'nicolas.durand@abionic.com', 0, 1, 4),
(18, 'Lasser/Renaud', '', '', '', 0, 0, 6),
(19, 'Clavel', '', '', '', 0, 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `id_sectors` int(11) NOT NULL,
  `sectors` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`id_sectors`, `sectors`) VALUES
(1, 'Architecture'),
(2, 'Biotech'),
(3, 'ICT'),
(4, 'Medtech'),
(5, 'Engineering'),
(6, 'Fintech'),
(7, 'Cleantech');

-- --------------------------------------------------------

--
-- Table structure for table `stage_of_investment`
--

CREATE TABLE `stage_of_investment` (
  `id_stage_of_investment` int(11) NOT NULL,
  `stage_of_investment` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `stage_of_investment`
--

INSERT INTO `stage_of_investment` (`id_stage_of_investment`, `stage_of_investment`) VALUES
(1, 'Pre-seed'),
(2, 'Seed'),
(3, 'Series A'),
(4, 'Series B'),
(5, 'Series C'),
(6, 'Trade'),
(7, 'IPO'),
(8, 'Growth'),
(9, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `startup`
--

CREATE TABLE `startup` (
  `id_startup` int(11) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `web` varchar(255) DEFAULT NULL,
  `founding_date` varchar(4) DEFAULT NULL,
  `rc` varchar(255) DEFAULT NULL,
  `exit_year` varchar(4) DEFAULT NULL,
  `epfl_grant` varchar(255) DEFAULT NULL,
  `awards_competitions` varchar(255) DEFAULT NULL,
  `key_words` varchar(255) DEFAULT NULL,
  `laboratory` varchar(30) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `fk_type` int(11) DEFAULT NULL,
  `fk_ceo_education_level` int(11) DEFAULT NULL,
  `fk_sectors` int(11) DEFAULT NULL,
  `fk_funding` int(11) DEFAULT NULL,
  `fk_category` int(11) DEFAULT NULL,
  `fk_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `startup`
--

INSERT INTO `startup` (`id_startup`, `company`, `web`, `founding_date`, `rc`, `exit_year`, `epfl_grant`, `awards_competitions`, `key_words`, `laboratory`, `short_description`, `fk_type`, `fk_ceo_education_level`, `fk_sectors`, `fk_funding`, `fk_category`, `fk_status`) VALUES
(4, '2C3D medical', NULL, '2000', 'CH-550.0.080.832-5', '2002', NULL, NULL, NULL, 'LSRO2', NULL, 1, 5, 4, 1, 1, 2),
(5, 'Abionic', NULL, '2010', NULL, NULL, NULL, NULL, 'Diagnostics', NULL, NULL, 1, 4, 4, 2, 1, 1),
(7, 'startupsss', 'www.web.ch', '2020', 'rc', '2021', 'epfl_grant', 'awards_competitions', 'key_words', 'labo', 'short_description', 1, 1, 7, 3, 1, 1),
(8, '2C3D medical', '', '2000', 'CH-550.0.080.832-5', '2002', '', '', '', 'LSRO2', '', 1, 5, 4, 4, 1, 2),
(9, 'Abionic', '', '2010', '', '', '', '', 'Diagnostics', '', '', 1, 4, 4, 5, 1, 1),
(10, 'startupsss', 'www.web.ch', '2020', 'rc', '2021', 'epfl_grant', 'awards_competitions', 'key_words', 'labo', 'short_description', 1, 1, 7, 6, 1, 1),
(11, 'HemostOD SA', 'www.hemostod.ch', '2010', 'CH-550.0.080.832-5', '2020', '', '', '', 'LSRO2', '', 3, 1, 5, 7, 1, 2);

-- --------------------------------------------------------

--
-- Table structure for table `startup_faculty_schools`
--

CREATE TABLE `startup_faculty_schools` (
  `id_startup_faculty_schools` int(11) NOT NULL,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_faculty_schools` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `startup_faculty_schools`
--

INSERT INTO `startup_faculty_schools` (`id_startup_faculty_schools`, `fk_startup`, `fk_faculty_schools`) VALUES
(1, 4, 6),
(2, 5, 1),
(3, 7, 2),
(4, 4, 1),
(5, 5, 7),
(6, 8, 6),
(7, 9, 1),
(8, 10, 1),
(9, 11, 7),
(10, NULL, 2),
(11, NULL, 1),
(12, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `startup_founders_country`
--

CREATE TABLE `startup_founders_country` (
  `id_startup_founders_country` int(11) NOT NULL,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_founders_country` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `startup_founders_country`
--

INSERT INTO `startup_founders_country` (`id_startup_founders_country`, `fk_startup`, `fk_founders_country`) VALUES
(1, 4, 12),
(2, 4, 10),
(3, 5, 17),
(4, 5, 7),
(5, 7, 9),
(6, 8, 12),
(7, 9, 10),
(8, 10, 17),
(9, 11, 7),
(10, NULL, 9),
(11, NULL, 1),
(12, NULL, 17);

-- --------------------------------------------------------

--
-- Table structure for table `startup_impact_sdg`
--

CREATE TABLE `startup_impact_sdg` (
  `id_startup_impact_sdg` int(11) NOT NULL,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_impact_sdg` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `startup_impact_sdg`
--

INSERT INTO `startup_impact_sdg` (`id_startup_impact_sdg`, `fk_startup`, `fk_impact_sdg`) VALUES
(1, 4, 3),
(2, 4, 6),
(3, 5, 3),
(4, 5, 10),
(5, 7, 16),
(6, 8, 3),
(7, 9, 6),
(8, 10, 3),
(9, 11, 10),
(10, NULL, 16),
(11, NULL, 15),
(12, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `startup_person`
--

CREATE TABLE `startup_person` (
  `id_startup_person` int(11) NOT NULL,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_person` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `startup_person`
--

INSERT INTO `startup_person` (`id_startup_person`, `fk_startup`, `fk_person`) VALUES
(6, 4, 13),
(7, 5, 15),
(8, 7, 14);

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `status`
--

INSERT INTO `status` (`id_status`, `status`) VALUES
(1, 'Private'),
(2, 'Stopped'),
(3, 'Public'),
(4, 'M&A');

-- --------------------------------------------------------

--
-- Table structure for table `type_of_investment`
--

CREATE TABLE `type_of_investment` (
  `id_type_of_investment` int(11) NOT NULL,
  `type_of_investment` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type_of_investment`
--

INSERT INTO `type_of_investment` (`id_type_of_investment`, `type_of_investment`) VALUES
(1, 'Equity'),
(2, 'Convertible Loans'),
(3, 'Loans'),
(4, 'Grants'),
(5, 'Award');

-- --------------------------------------------------------

--
-- Table structure for table `type_of_person`
--

CREATE TABLE `type_of_person` (
  `id_type_of_person` int(11) NOT NULL,
  `type_of_person` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type_of_person`
--

INSERT INTO `type_of_person` (`id_type_of_person`, `type_of_person`) VALUES
(4, 'CEO'),
(5, 'Co-founder'),
(6, 'Prof');

-- --------------------------------------------------------

--
-- Table structure for table `type_startup`
--

CREATE TABLE `type_startup` (
  `id_type_startup` int(11) NOT NULL,
  `type_startup` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `type_startup`
--

INSERT INTO `type_startup` (`id_type_startup`, `type_startup`) VALUES
(1, 'SA'),
(2, 'Sàrl'),
(3, 'SNC'),
(4, 'Association'),
(5, 'Individuelle'),
(6, 'Soc. nom indiv.');

-- --------------------------------------------------------

--
-- Structure for view `detail_startup`
--
DROP TABLE IF EXISTS `detail_startup`;

CREATE ALGORITHM=UNDEFINED DEFINER=`testing`@`%` SQL SECURITY DEFINER VIEW `detail_startup`  AS SELECT `startup`.`id_startup` AS `id_startup`, `startup`.`company` AS `company`, `startup`.`web` AS `web`, `startup`.`founding_date` AS `founding_date`, `startup`.`rc` AS `rc`, `startup`.`exit_year` AS `exit_year`, `startup`.`epfl_grant` AS `epfl_grant`, `startup`.`awards_competitions` AS `awards_competitions`, `startup`.`laboratory` AS `laboratory`, `startup`.`short_description` AS `short_description`, `status`.`status` AS `status`, `type_startup`.`type_startup` AS `type_startup`, `sectors`.`sectors` AS `sectors`, `category`.`category` AS `category`, `ceo_education_level`.`ceo_education_level` AS `ceo_education_level`, group_concat(`founders_country`.`founders_country` separator ';') AS `country`, group_concat(`impact_sdg`.`impact_sdg` separator ';') AS `impact` FROM (((((((((((`startup` join `startup_person` on(`startup`.`id_startup` = `startup_person`.`fk_startup`)) join `person` on(`startup_person`.`fk_person` = `person`.`id_person`)) join `status` on(`status`.`id_status` = `startup`.`fk_status`)) join `type_startup` on(`type_startup`.`id_type_startup` = `startup`.`fk_type`)) join `sectors` on(`sectors`.`id_sectors` = `startup`.`fk_sectors`)) join `category` on(`category`.`id_category` = `startup`.`fk_category`)) join `ceo_education_level` on(`ceo_education_level`.`id_ceo_education_level` = `startup`.`fk_ceo_education_level`)) join `startup_founders_country` on(`startup`.`id_startup` = `startup_founders_country`.`fk_startup`)) join `founders_country` on(`founders_country`.`id_founders_country` = `startup_founders_country`.`fk_founders_country`)) join `startup_impact_sdg` on(`startup`.`id_startup` = `startup_impact_sdg`.`fk_startup`)) join `impact_sdg` on(`impact_sdg`.`id_impact_sdg` = `startup_impact_sdg`.`fk_impact_sdg`)) GROUP BY `startup`.`company` ;

-- --------------------------------------------------------

--
-- Structure for view `funds_by_sector`
--
DROP TABLE IF EXISTS `funds_by_sector`;

CREATE ALGORITHM=UNDEFINED DEFINER=`testing`@`%` SQL SECURITY DEFINER VIEW `funds_by_sector`  AS SELECT `sectors`.`sectors` AS `sectors`, sum(`funding`.`amount`) AS `amount` FROM ((`startup` join `funding` on(`funding`.`id_funding` = `startup`.`fk_funding`)) join `sectors` on(`sectors`.`id_sectors` = `startup`.`fk_sectors`)) GROUP BY `sectors`.`sectors` ORDER BY `sectors`.`sectors` ASC ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indexes for table `ceo_education_level`
--
ALTER TABLE `ceo_education_level`
  ADD PRIMARY KEY (`id_ceo_education_level`);

--
-- Indexes for table `faculty_schools`
--
ALTER TABLE `faculty_schools`
  ADD PRIMARY KEY (`id_faculty_schools`);

--
-- Indexes for table `founders_country`
--
ALTER TABLE `founders_country`
  ADD PRIMARY KEY (`id_founders_country`);

--
-- Indexes for table `funding`
--
ALTER TABLE `funding`
  ADD PRIMARY KEY (`id_funding`),
  ADD KEY `fk_stage_of_investment` (`fk_stage_of_investment`),
  ADD KEY `fk_type_of_investment` (`fk_type_of_investment`);

--
-- Indexes for table `impact_sdg`
--
ALTER TABLE `impact_sdg`
  ADD PRIMARY KEY (`id_impact_sdg`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id_person`),
  ADD KEY `fk_type_of_person` (`fk_type_of_person`);

--
-- Indexes for table `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id_sectors`);

--
-- Indexes for table `stage_of_investment`
--
ALTER TABLE `stage_of_investment`
  ADD PRIMARY KEY (`id_stage_of_investment`);

--
-- Indexes for table `startup`
--
ALTER TABLE `startup`
  ADD PRIMARY KEY (`id_startup`),
  ADD KEY `fk_type` (`fk_type`),
  ADD KEY `fk_ceo_education_level` (`fk_ceo_education_level`),
  ADD KEY `fk_sectors` (`fk_sectors`),
  ADD KEY `fk_funding` (`fk_funding`),
  ADD KEY `fk_category` (`fk_category`),
  ADD KEY `fk_status` (`fk_status`);

--
-- Indexes for table `startup_faculty_schools`
--
ALTER TABLE `startup_faculty_schools`
  ADD PRIMARY KEY (`id_startup_faculty_schools`),
  ADD KEY `fk_startup` (`fk_startup`),
  ADD KEY `fk_faculty_schools` (`fk_faculty_schools`);

--
-- Indexes for table `startup_founders_country`
--
ALTER TABLE `startup_founders_country`
  ADD PRIMARY KEY (`id_startup_founders_country`),
  ADD KEY `fk_startup` (`fk_startup`),
  ADD KEY `fk_founders_country` (`fk_founders_country`);

--
-- Indexes for table `startup_impact_sdg`
--
ALTER TABLE `startup_impact_sdg`
  ADD PRIMARY KEY (`id_startup_impact_sdg`),
  ADD KEY `fk_startup` (`fk_startup`),
  ADD KEY `fk_impact_sdg` (`fk_impact_sdg`);

--
-- Indexes for table `startup_person`
--
ALTER TABLE `startup_person`
  ADD PRIMARY KEY (`id_startup_person`),
  ADD KEY `fk_startup` (`fk_startup`),
  ADD KEY `fk_person` (`fk_person`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id_status`);

--
-- Indexes for table `type_of_investment`
--
ALTER TABLE `type_of_investment`
  ADD PRIMARY KEY (`id_type_of_investment`);

--
-- Indexes for table `type_of_person`
--
ALTER TABLE `type_of_person`
  ADD PRIMARY KEY (`id_type_of_person`);

--
-- Indexes for table `type_startup`
--
ALTER TABLE `type_startup`
  ADD PRIMARY KEY (`id_type_startup`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id_category` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ceo_education_level`
--
ALTER TABLE `ceo_education_level`
  MODIFY `id_ceo_education_level` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `faculty_schools`
--
ALTER TABLE `faculty_schools`
  MODIFY `id_faculty_schools` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `founders_country`
--
ALTER TABLE `founders_country`
  MODIFY `id_founders_country` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `funding`
--
ALTER TABLE `funding`
  MODIFY `id_funding` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `impact_sdg`
--
ALTER TABLE `impact_sdg`
  MODIFY `id_impact_sdg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `id_person` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id_sectors` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `stage_of_investment`
--
ALTER TABLE `stage_of_investment`
  MODIFY `id_stage_of_investment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `startup`
--
ALTER TABLE `startup`
  MODIFY `id_startup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `startup_faculty_schools`
--
ALTER TABLE `startup_faculty_schools`
  MODIFY `id_startup_faculty_schools` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `startup_founders_country`
--
ALTER TABLE `startup_founders_country`
  MODIFY `id_startup_founders_country` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `startup_impact_sdg`
--
ALTER TABLE `startup_impact_sdg`
  MODIFY `id_startup_impact_sdg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `startup_person`
--
ALTER TABLE `startup_person`
  MODIFY `id_startup_person` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `type_of_investment`
--
ALTER TABLE `type_of_investment`
  MODIFY `id_type_of_investment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `type_of_person`
--
ALTER TABLE `type_of_person`
  MODIFY `id_type_of_person` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `type_startup`
--
ALTER TABLE `type_startup`
  MODIFY `id_type_startup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `funding`
--
ALTER TABLE `funding`
  ADD CONSTRAINT `funding_ibfk_1` FOREIGN KEY (`fk_stage_of_investment`) REFERENCES `stage_of_investment` (`id_stage_of_investment`),
  ADD CONSTRAINT `funding_ibfk_2` FOREIGN KEY (`fk_type_of_investment`) REFERENCES `type_of_investment` (`id_type_of_investment`);

--
-- Constraints for table `person`
--
ALTER TABLE `person`
  ADD CONSTRAINT `person_ibfk_1` FOREIGN KEY (`fk_type_of_person`) REFERENCES `type_of_person` (`id_type_of_person`);

--
-- Constraints for table `startup`
--
ALTER TABLE `startup`
  ADD CONSTRAINT `startup_ibfk_1` FOREIGN KEY (`fk_type`) REFERENCES `type_startup` (`id_type_startup`),
  ADD CONSTRAINT `startup_ibfk_2` FOREIGN KEY (`fk_ceo_education_level`) REFERENCES `ceo_education_level` (`id_ceo_education_level`),
  ADD CONSTRAINT `startup_ibfk_4` FOREIGN KEY (`fk_sectors`) REFERENCES `sectors` (`id_sectors`),
  ADD CONSTRAINT `startup_ibfk_5` FOREIGN KEY (`fk_funding`) REFERENCES `funding` (`id_funding`),
  ADD CONSTRAINT `startup_ibfk_7` FOREIGN KEY (`fk_category`) REFERENCES `category` (`id_category`),
  ADD CONSTRAINT `startup_ibfk_8` FOREIGN KEY (`fk_status`) REFERENCES `status` (`id_status`);

--
-- Constraints for table `startup_faculty_schools`
--
ALTER TABLE `startup_faculty_schools`
  ADD CONSTRAINT `startup_faculty_schools_ibfk_1` FOREIGN KEY (`fk_startup`) REFERENCES `startup` (`id_startup`),
  ADD CONSTRAINT `startup_faculty_schools_ibfk_2` FOREIGN KEY (`fk_faculty_schools`) REFERENCES `faculty_schools` (`id_faculty_schools`);

--
-- Constraints for table `startup_founders_country`
--
ALTER TABLE `startup_founders_country`
  ADD CONSTRAINT `startup_founders_country_ibfk_1` FOREIGN KEY (`fk_startup`) REFERENCES `startup` (`id_startup`),
  ADD CONSTRAINT `startup_founders_country_ibfk_2` FOREIGN KEY (`fk_founders_country`) REFERENCES `founders_country` (`id_founders_country`);

--
-- Constraints for table `startup_impact_sdg`
--
ALTER TABLE `startup_impact_sdg`
  ADD CONSTRAINT `startup_impact_sdg_ibfk_1` FOREIGN KEY (`fk_startup`) REFERENCES `startup` (`id_startup`),
  ADD CONSTRAINT `startup_impact_sdg_ibfk_2` FOREIGN KEY (`fk_impact_sdg`) REFERENCES `impact_sdg` (`id_impact_sdg`);

--
-- Constraints for table `startup_person`
--
ALTER TABLE `startup_person`
  ADD CONSTRAINT `startup_person_ibfk_1` FOREIGN KEY (`fk_startup`) REFERENCES `startup` (`id_startup`),
  ADD CONSTRAINT `startup_person_ibfk_2` FOREIGN KEY (`fk_person`) REFERENCES `person` (`id_person`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
