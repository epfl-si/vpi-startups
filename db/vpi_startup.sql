-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: db:3306
-- Generation Time: Apr 29, 2021 at 08:06 AM
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
-- Table structure for table `ceo_education_level`
--

CREATE TABLE `ceo_education_level` (
  `id_ceo_education_level` int(11) NOT NULL,
  `ceo_education_level` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `faculty_schools`
--

CREATE TABLE `faculty_schools` (
  `id_faculty_schools` int(11) NOT NULL,
  `faculty_schools` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `founders_country`
--

CREATE TABLE `founders_country` (
  `id_founders_country` int(11) NOT NULL,
  `founders_country` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `funding`
--

CREATE TABLE `funding` (
  `id_funding` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `investment_date` date DEFAULT NULL,
  `investors` varchar(30) DEFAULT NULL,
  `fk_stage_of_investment` int(11) DEFAULT NULL,
  `fk_type_of_investment` int(11) DEFAULT NULL,
  `fk_startup` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `impact_sdg`
--

CREATE TABLE `impact_sdg` (
  `id_impact_sdg` int(11) NOT NULL,
  `impact_sdg` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `logs`
--

CREATE TABLE `logs` (
  `id_logs` int(11) NOT NULL,
  `sciper_number` int(11) NOT NULL,
  `date_logs` date NOT NULL,
  `after_logs` varchar(255) NOT NULL,
  `before_logs` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `gender` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `sectors`
--

CREATE TABLE `sectors` (
  `id_sectors` int(11) NOT NULL,
  `sectors` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `stage_of_investment`
--

CREATE TABLE `stage_of_investment` (
  `id_stage_of_investment` int(11) NOT NULL,
  `stage_of_investment` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  `fk_category` int(11) DEFAULT NULL,
  `fk_status` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `startup_faculty_schools`
--

CREATE TABLE `startup_faculty_schools` (
  `id_startup_faculty_schools` int(11) NOT NULL,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_faculty_schools` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `startup_founders_country`
--

CREATE TABLE `startup_founders_country` (
  `id_startup_founders_country` int(11) NOT NULL,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_founders_country` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `startup_impact_sdg`
--

CREATE TABLE `startup_impact_sdg` (
  `id_startup_impact_sdg` int(11) NOT NULL,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_impact_sdg` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `startup_person`
--

CREATE TABLE `startup_person` (
  `id_startup_person` int(11) NOT NULL,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_person` int(11) DEFAULT NULL,
  `fk_type_of_person` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `type_of_investment`
--

CREATE TABLE `type_of_investment` (
  `id_type_of_investment` int(11) NOT NULL,
  `type_of_investment` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `type_of_person`
--

CREATE TABLE `type_of_person` (
  `id_type_of_person` int(11) NOT NULL,
  `type_of_person` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `type_startup`
--

CREATE TABLE `type_startup` (
  `id_type_startup` int(11) NOT NULL,
  `type_startup` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Stand-in structure for view `view_detail_startup`
-- (See below for the actual view)
--
CREATE TABLE `view_detail_startup` (
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
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_detail_startup_full`
-- (See below for the actual view)
--
CREATE TABLE `view_detail_startup_full` (
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
,`schools` mediumtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_funds_by_sector`
-- (See below for the actual view)
--
CREATE TABLE `view_funds_by_sector` (
`sectors` varchar(30)
,`amount` double
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_number_of_startups_by_year`
-- (See below for the actual view)
--
CREATE TABLE `view_number_of_startups_by_year` (
`founding_date` varchar(4)
,`number_of_companies` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_startups_by_sector`
-- (See below for the actual view)
--
CREATE TABLE `view_startups_by_sector` (
`sectors` varchar(30)
,`company` bigint(21)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_startup_country`
-- (See below for the actual view)
--
CREATE TABLE `view_startup_country` (
`id_startup` int(11)
,`country` mediumtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_startup_faculty_schools`
-- (See below for the actual view)
--
CREATE TABLE `view_startup_faculty_schools` (
`id_startup` int(11)
,`schools` mediumtext
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_startup_impact`
-- (See below for the actual view)
--
CREATE TABLE `view_startup_impact` (
`id_startup` int(11)
,`impact` mediumtext
);

-- --------------------------------------------------------

--
-- Structure for view `view_detail_startup`
--
DROP TABLE IF EXISTS `view_detail_startup`;

CREATE ALGORITHM=UNDEFINED DEFINER=`testing`@`%` SQL SECURITY DEFINER VIEW `view_detail_startup`  AS SELECT `startup`.`id_startup` AS `id_startup`, `startup`.`company` AS `company`, `startup`.`web` AS `web`, `startup`.`founding_date` AS `founding_date`, `startup`.`rc` AS `rc`, `startup`.`exit_year` AS `exit_year`, `startup`.`epfl_grant` AS `epfl_grant`, `startup`.`awards_competitions` AS `awards_competitions`, `startup`.`laboratory` AS `laboratory`, `startup`.`short_description` AS `short_description`, `status`.`status` AS `status`, `type_startup`.`type_startup` AS `type_startup`, `sectors`.`sectors` AS `sectors`, `category`.`category` AS `category`, `ceo_education_level`.`ceo_education_level` AS `ceo_education_level` FROM (((((`startup` join `status` on(`status`.`id_status` = `startup`.`fk_status`)) join `type_startup` on(`type_startup`.`id_type_startup` = `startup`.`fk_type`)) join `sectors` on(`sectors`.`id_sectors` = `startup`.`fk_sectors`)) join `category` on(`category`.`id_category` = `startup`.`fk_category`)) join `ceo_education_level` on(`ceo_education_level`.`id_ceo_education_level` = `startup`.`fk_ceo_education_level`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_detail_startup_full`
--
DROP TABLE IF EXISTS `view_detail_startup_full`;

CREATE ALGORITHM=UNDEFINED DEFINER=`testing`@`%` SQL SECURITY DEFINER VIEW `view_detail_startup_full`  AS SELECT `view_detail_startup`.`id_startup` AS `id_startup`, `view_detail_startup`.`company` AS `company`, `view_detail_startup`.`web` AS `web`, `view_detail_startup`.`founding_date` AS `founding_date`, `view_detail_startup`.`rc` AS `rc`, `view_detail_startup`.`exit_year` AS `exit_year`, `view_detail_startup`.`epfl_grant` AS `epfl_grant`, `view_detail_startup`.`awards_competitions` AS `awards_competitions`, `view_detail_startup`.`laboratory` AS `laboratory`, `view_detail_startup`.`short_description` AS `short_description`, `view_detail_startup`.`status` AS `status`, `view_detail_startup`.`type_startup` AS `type_startup`, `view_detail_startup`.`sectors` AS `sectors`, `view_detail_startup`.`category` AS `category`, `view_detail_startup`.`ceo_education_level` AS `ceo_education_level`, `view_startup_country`.`country` AS `country`, `view_startup_impact`.`impact` AS `impact`, `view_startup_faculty_schools`.`schools` AS `schools` FROM (((`view_detail_startup` join `view_startup_country` on(`view_detail_startup`.`id_startup` = `view_startup_country`.`id_startup`)) join `view_startup_impact` on(`view_detail_startup`.`id_startup` = `view_startup_impact`.`id_startup`)) join `view_startup_faculty_schools` on(`view_detail_startup`.`id_startup` = `view_startup_faculty_schools`.`id_startup`)) ;

-- --------------------------------------------------------

--
-- Structure for view `view_funds_by_sector`
--
DROP TABLE IF EXISTS `view_funds_by_sector`;

CREATE ALGORITHM=UNDEFINED DEFINER=`testing`@`%` SQL SECURITY DEFINER VIEW `view_funds_by_sector`  AS SELECT `sectors`.`sectors` AS `sectors`, sum(`funding`.`amount`) AS `amount` FROM ((`startup` join `funding` on(`funding`.`fk_startup` = `startup`.`id_startup`)) join `sectors` on(`sectors`.`id_sectors` = `startup`.`fk_sectors`)) GROUP BY `sectors`.`sectors` ORDER BY `sectors`.`sectors` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `view_number_of_startups_by_year`
--
DROP TABLE IF EXISTS `view_number_of_startups_by_year`;

CREATE ALGORITHM=UNDEFINED DEFINER=`testing`@`%` SQL SECURITY DEFINER VIEW `view_number_of_startups_by_year`  AS SELECT `startup`.`founding_date` AS `founding_date`, count(`startup`.`company`) AS `number_of_companies` FROM `startup` GROUP BY `startup`.`founding_date` ORDER BY `startup`.`founding_date` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `view_startups_by_sector`
--
DROP TABLE IF EXISTS `view_startups_by_sector`;

CREATE ALGORITHM=UNDEFINED DEFINER=`testing`@`%` SQL SECURITY DEFINER VIEW `view_startups_by_sector`  AS SELECT `sectors`.`sectors` AS `sectors`, count(`startup`.`company`) AS `company` FROM (`startup` join `sectors` on(`sectors`.`id_sectors` = `startup`.`fk_sectors`)) GROUP BY `sectors`.`sectors` ORDER BY `sectors`.`sectors` ASC ;

-- --------------------------------------------------------

--
-- Structure for view `view_startup_country`
--
DROP TABLE IF EXISTS `view_startup_country`;

CREATE ALGORITHM=UNDEFINED DEFINER=`testing`@`%` SQL SECURITY DEFINER VIEW `view_startup_country`  AS SELECT `startup`.`id_startup` AS `id_startup`, group_concat(`founders_country`.`founders_country` separator ';') AS `country` FROM ((`startup` join `startup_founders_country` on(`startup`.`id_startup` = `startup_founders_country`.`fk_startup`)) join `founders_country` on(`founders_country`.`id_founders_country` = `startup_founders_country`.`fk_founders_country`)) GROUP BY `startup`.`id_startup` ;

-- --------------------------------------------------------

--
-- Structure for view `view_startup_faculty_schools`
--
DROP TABLE IF EXISTS `view_startup_faculty_schools`;

CREATE ALGORITHM=UNDEFINED DEFINER=`testing`@`%` SQL SECURITY DEFINER VIEW `view_startup_faculty_schools`  AS SELECT `startup`.`id_startup` AS `id_startup`, group_concat(`faculty_schools`.`faculty_schools` separator ';') AS `schools` FROM ((`startup` join `startup_faculty_schools` on(`startup`.`id_startup` = `startup_faculty_schools`.`fk_startup`)) join `faculty_schools` on(`faculty_schools`.`id_faculty_schools` = `startup_faculty_schools`.`fk_faculty_schools`)) GROUP BY `startup`.`id_startup` ;

-- --------------------------------------------------------

--
-- Structure for view `view_startup_impact`
--
DROP TABLE IF EXISTS `view_startup_impact`;

CREATE ALGORITHM=UNDEFINED DEFINER=`testing`@`%` SQL SECURITY DEFINER VIEW `view_startup_impact`  AS SELECT `startup`.`id_startup` AS `id_startup`, group_concat(`impact_sdg`.`impact_sdg` separator ';') AS `impact` FROM ((`startup` join `startup_impact_sdg` on(`startup`.`id_startup` = `startup_impact_sdg`.`fk_startup`)) join `impact_sdg` on(`impact_sdg`.`id_impact_sdg` = `startup_impact_sdg`.`fk_impact_sdg`)) GROUP BY `startup`.`id_startup` ;

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
  ADD KEY `fk_type_of_investment` (`fk_type_of_investment`),
  ADD KEY `funding_ibfk_3` (`fk_startup`);

--
-- Indexes for table `impact_sdg`
--
ALTER TABLE `impact_sdg`
  ADD PRIMARY KEY (`id_impact_sdg`);

--
-- Indexes for table `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id_logs`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`id_person`);

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
  ADD KEY `fk_person` (`fk_person`),
  ADD KEY `fk_type_of_person` (`fk_type_of_person`);

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
-- AUTO_INCREMENT for table `logs`
--
ALTER TABLE `logs`
  MODIFY `id_logs` int(11) NOT NULL AUTO_INCREMENT;

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
  MODIFY `id_startup` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `startup_faculty_schools`
--
ALTER TABLE `startup_faculty_schools`
  MODIFY `id_startup_faculty_schools` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- AUTO_INCREMENT for table `startup_founders_country`
--
ALTER TABLE `startup_founders_country`
  MODIFY `id_startup_founders_country` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT for table `startup_impact_sdg`
--
ALTER TABLE `startup_impact_sdg`
  MODIFY `id_startup_impact_sdg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `startup_person`
--
ALTER TABLE `startup_person`
  MODIFY `id_startup_person` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

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
  ADD CONSTRAINT `funding_ibfk_2` FOREIGN KEY (`fk_type_of_investment`) REFERENCES `type_of_investment` (`id_type_of_investment`),
  ADD CONSTRAINT `funding_ibfk_3` FOREIGN KEY (`fk_startup`) REFERENCES `startup` (`id_startup`);

--
-- Constraints for table `startup`
--
ALTER TABLE `startup`
  ADD CONSTRAINT `startup_ibfk_1` FOREIGN KEY (`fk_type`) REFERENCES `type_startup` (`id_type_startup`),
  ADD CONSTRAINT `startup_ibfk_2` FOREIGN KEY (`fk_ceo_education_level`) REFERENCES `ceo_education_level` (`id_ceo_education_level`),
  ADD CONSTRAINT `startup_ibfk_4` FOREIGN KEY (`fk_sectors`) REFERENCES `sectors` (`id_sectors`),
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
  ADD CONSTRAINT `startup_person_ibfk_2` FOREIGN KEY (`fk_person`) REFERENCES `person` (`id_person`),
  ADD CONSTRAINT `startup_person_ibfk_3` FOREIGN KEY (`fk_type_of_person`) REFERENCES `type_of_person` (`id_type_of_person`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
