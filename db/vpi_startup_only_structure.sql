-- MariaDB dump 10.19  Distrib 10.5.9-MariaDB, for debian-linux-gnu (aarch64)
--
-- Host: localhost    Database: vpi_startup
-- ------------------------------------------------------
-- Server version	10.5.9-MariaDB-1:10.5.9+maria~focal

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ceo_education_level`
--

DROP TABLE IF EXISTS `ceo_education_level`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ceo_education_level` (
  `id_ceo_education_level` int(11) NOT NULL AUTO_INCREMENT,
  `ceo_education_level` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_ceo_education_level`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `faculty_schools`
--

DROP TABLE IF EXISTS `faculty_schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `faculty_schools` (
  `id_faculty_schools` int(11) NOT NULL AUTO_INCREMENT,
  `faculty_schools` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_faculty_schools`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `founders_country`
--

DROP TABLE IF EXISTS `founders_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `founders_country` (
  `id_founders_country` int(11) NOT NULL AUTO_INCREMENT,
  `founders_country` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_founders_country`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `funding`
--

DROP TABLE IF EXISTS `funding`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `funding` (
  `id_funding` int(11) NOT NULL AUTO_INCREMENT,
  `amount` int(20) NOT NULL,
  `investment_date` date DEFAULT NULL,
  `investors` varchar(30) DEFAULT NULL,
  `fk_stage_of_investment` int(11) DEFAULT NULL,
  `fk_type_of_investment` int(11) DEFAULT NULL,
  `fk_startup` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_funding`),
  KEY `fk_stage_of_investment` (`fk_stage_of_investment`),
  KEY `fk_type_of_investment` (`fk_type_of_investment`),
  KEY `funding_ibfk_3` (`fk_startup`),
  CONSTRAINT `funding_ibfk_1` FOREIGN KEY (`fk_stage_of_investment`) REFERENCES `stage_of_investment` (`id_stage_of_investment`),
  CONSTRAINT `funding_ibfk_2` FOREIGN KEY (`fk_type_of_investment`) REFERENCES `type_of_investment` (`id_type_of_investment`),
  CONSTRAINT `funding_ibfk_3` FOREIGN KEY (`fk_startup`) REFERENCES `startup` (`id_startup`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `impact_sdg`
--

DROP TABLE IF EXISTS `impact_sdg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `impact_sdg` (
  `id_impact_sdg` int(11) NOT NULL AUTO_INCREMENT,
  `impact_sdg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_impact_sdg`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id_logs` int(11) NOT NULL AUTO_INCREMENT,
  `sciper_number` int(11) NOT NULL,
  `date_logs` datetime NOT NULL,
  `before_changes` blob NOT NULL,
  `after_changes` blob NOT NULL,
  `action` varchar(255) NOT NULL,
  PRIMARY KEY (`id_logs`)
) ENGINE=InnoDB AUTO_INCREMENT=338 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `id_person` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) DEFAULT NULL,
  `firstname` varchar(20) DEFAULT NULL,
  `person_function` varchar(30) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `prof_as_founder` tinyint(1) DEFAULT NULL,
  `gender` tinyint(1) DEFAULT NULL,
  `sciper_number` int(8) DEFAULT NULL,
  PRIMARY KEY (`id_person`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sectors`
--

DROP TABLE IF EXISTS `sectors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sectors` (
  `id_sectors` int(11) NOT NULL AUTO_INCREMENT,
  `sectors` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_sectors`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stage_of_investment`
--

DROP TABLE IF EXISTS `stage_of_investment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stage_of_investment` (
  `id_stage_of_investment` int(11) NOT NULL AUTO_INCREMENT,
  `stage_of_investment` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_stage_of_investment`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `startup`
--

DROP TABLE IF EXISTS `startup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `startup` (
  `id_startup` int(11) NOT NULL AUTO_INCREMENT,
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
  `company_uid` varchar(20) DEFAULT NULL,
  `crunchbase_uid` varchar(20) DEFAULT NULL,
  `unit_path` varchar(20) DEFAULT NULL,
  `fk_type` int(11) DEFAULT NULL,
  `fk_ceo_education_level` int(11) DEFAULT NULL,
  `fk_sectors` int(11) DEFAULT NULL,
  `fk_category` int(11) DEFAULT NULL,
  `fk_status` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_startup`),
  KEY `fk_type` (`fk_type`),
  KEY `fk_ceo_education_level` (`fk_ceo_education_level`),
  KEY `fk_sectors` (`fk_sectors`),
  KEY `fk_category` (`fk_category`),
  KEY `fk_status` (`fk_status`),
  CONSTRAINT `startup_ibfk_1` FOREIGN KEY (`fk_type`) REFERENCES `type_startup` (`id_type_startup`),
  CONSTRAINT `startup_ibfk_2` FOREIGN KEY (`fk_ceo_education_level`) REFERENCES `ceo_education_level` (`id_ceo_education_level`),
  CONSTRAINT `startup_ibfk_4` FOREIGN KEY (`fk_sectors`) REFERENCES `sectors` (`id_sectors`),
  CONSTRAINT `startup_ibfk_7` FOREIGN KEY (`fk_category`) REFERENCES `category` (`id_category`),
  CONSTRAINT `startup_ibfk_8` FOREIGN KEY (`fk_status`) REFERENCES `status` (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `startup_faculty_schools`
--

DROP TABLE IF EXISTS `startup_faculty_schools`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `startup_faculty_schools` (
  `id_startup_faculty_schools` int(11) NOT NULL AUTO_INCREMENT,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_faculty_schools` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_startup_faculty_schools`),
  KEY `fk_startup` (`fk_startup`),
  KEY `fk_faculty_schools` (`fk_faculty_schools`),
  CONSTRAINT `startup_faculty_schools_ibfk_1` FOREIGN KEY (`fk_startup`) REFERENCES `startup` (`id_startup`),
  CONSTRAINT `startup_faculty_schools_ibfk_2` FOREIGN KEY (`fk_faculty_schools`) REFERENCES `faculty_schools` (`id_faculty_schools`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `startup_founders_country`
--

DROP TABLE IF EXISTS `startup_founders_country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `startup_founders_country` (
  `id_startup_founders_country` int(11) NOT NULL AUTO_INCREMENT,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_founders_country` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_startup_founders_country`),
  KEY `fk_startup` (`fk_startup`),
  KEY `fk_founders_country` (`fk_founders_country`),
  CONSTRAINT `startup_founders_country_ibfk_1` FOREIGN KEY (`fk_startup`) REFERENCES `startup` (`id_startup`),
  CONSTRAINT `startup_founders_country_ibfk_2` FOREIGN KEY (`fk_founders_country`) REFERENCES `founders_country` (`id_founders_country`)
) ENGINE=InnoDB AUTO_INCREMENT=200 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `startup_impact_sdg`
--

DROP TABLE IF EXISTS `startup_impact_sdg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `startup_impact_sdg` (
  `id_startup_impact_sdg` int(11) NOT NULL AUTO_INCREMENT,
  `fk_startup` int(11) DEFAULT NULL,
  `fk_impact_sdg` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_startup_impact_sdg`),
  KEY `fk_startup` (`fk_startup`),
  KEY `fk_impact_sdg` (`fk_impact_sdg`),
  CONSTRAINT `startup_impact_sdg_ibfk_1` FOREIGN KEY (`fk_startup`) REFERENCES `startup` (`id_startup`),
  CONSTRAINT `startup_impact_sdg_ibfk_2` FOREIGN KEY (`fk_impact_sdg`) REFERENCES `impact_sdg` (`id_impact_sdg`)
) ENGINE=InnoDB AUTO_INCREMENT=211 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `startup_person`
--

DROP TABLE IF EXISTS `startup_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `startup_person` (
  `id_startup_person` int(11) NOT NULL AUTO_INCREMENT,
  `fk_startup` int(11) NOT NULL,
  `fk_person` int(11) NOT NULL,
  `fk_type_of_person` int(11) NOT NULL,
  PRIMARY KEY (`id_startup_person`),
  KEY `fk_startup` (`fk_startup`),
  KEY `fk_person` (`fk_person`),
  KEY `fk_type_of_person` (`fk_type_of_person`),
  CONSTRAINT `startup_person_ibfk_1` FOREIGN KEY (`fk_startup`) REFERENCES `startup` (`id_startup`),
  CONSTRAINT `startup_person_ibfk_2` FOREIGN KEY (`fk_person`) REFERENCES `person` (`id_person`),
  CONSTRAINT `startup_person_ibfk_3` FOREIGN KEY (`fk_type_of_person`) REFERENCES `type_of_person` (`id_type_of_person`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `status`
--

DROP TABLE IF EXISTS `status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status` (
  `id_status` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `type_of_investment`
--

DROP TABLE IF EXISTS `type_of_investment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_of_investment` (
  `id_type_of_investment` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_investment` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_type_of_investment`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `type_of_person`
--

DROP TABLE IF EXISTS `type_of_person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_of_person` (
  `id_type_of_person` int(11) NOT NULL AUTO_INCREMENT,
  `type_of_person` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_type_of_person`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `type_startup`
--

DROP TABLE IF EXISTS `type_startup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `type_startup` (
  `id_type_startup` int(11) NOT NULL AUTO_INCREMENT,
  `type_startup` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id_type_startup`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary table structure for view `view_detail_startup`
--

DROP TABLE IF EXISTS `view_detail_startup`;
/*!50001 DROP VIEW IF EXISTS `view_detail_startup`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_detail_startup` (
  `id_startup` tinyint NOT NULL,
  `company` tinyint NOT NULL,
  `web` tinyint NOT NULL,
  `founding_date` tinyint NOT NULL,
  `rc` tinyint NOT NULL,
  `exit_year` tinyint NOT NULL,
  `epfl_grant` tinyint NOT NULL,
  `awards_competitions` tinyint NOT NULL,
  `key_words` tinyint NOT NULL,
  `laboratory` tinyint NOT NULL,
  `short_description` tinyint NOT NULL,
  `company_uid` tinyint NOT NULL,
  `crunchbase_uid` tinyint NOT NULL,
  `unit_path` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `type_startup` tinyint NOT NULL,
  `sectors` tinyint NOT NULL,
  `category` tinyint NOT NULL,
  `ceo_education_level` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_detail_startup_full`
--

DROP TABLE IF EXISTS `view_detail_startup_full`;
/*!50001 DROP VIEW IF EXISTS `view_detail_startup_full`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_detail_startup_full` (
  `id_startup` tinyint NOT NULL,
  `company` tinyint NOT NULL,
  `web` tinyint NOT NULL,
  `founding_date` tinyint NOT NULL,
  `rc` tinyint NOT NULL,
  `exit_year` tinyint NOT NULL,
  `epfl_grant` tinyint NOT NULL,
  `awards_competitions` tinyint NOT NULL,
  `key_words` tinyint NOT NULL,
  `laboratory` tinyint NOT NULL,
  `short_description` tinyint NOT NULL,
  `company_uid` tinyint NOT NULL,
  `crunchbase_uid` tinyint NOT NULL,
  `unit_path` tinyint NOT NULL,
  `status` tinyint NOT NULL,
  `type_startup` tinyint NOT NULL,
  `sectors` tinyint NOT NULL,
  `category` tinyint NOT NULL,
  `ceo_education_level` tinyint NOT NULL,
  `country` tinyint NOT NULL,
  `impact` tinyint NOT NULL,
  `schools` tinyint NOT NULL,
  `id_startup_person1` tinyint NOT NULL,
  `id_person1` tinyint NOT NULL,
  `name1` tinyint NOT NULL,
  `firstname1` tinyint NOT NULL,
  `id_type_of_person1` tinyint NOT NULL,
  `type_of_person1` tinyint NOT NULL,
  `id_startup_person2` tinyint NOT NULL,
  `id_person2` tinyint NOT NULL,
  `name2` tinyint NOT NULL,
  `firstname2` tinyint NOT NULL,
  `id_type_of_person2` tinyint NOT NULL,
  `type_of_person2` tinyint NOT NULL,
  `id_startup_person3` tinyint NOT NULL,
  `id_person3` tinyint NOT NULL,
  `name3` tinyint NOT NULL,
  `firstname3` tinyint NOT NULL,
  `id_type_of_person3` tinyint NOT NULL,
  `type_of_person3` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_display_funds`
--

DROP TABLE IF EXISTS `view_display_funds`;
/*!50001 DROP VIEW IF EXISTS `view_display_funds`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_display_funds` (
  `id_funding` tinyint NOT NULL,
  `amount` tinyint NOT NULL,
  `investment_date` tinyint NOT NULL,
  `investors` tinyint NOT NULL,
  `fk_startup` tinyint NOT NULL,
  `stage_of_investment` tinyint NOT NULL,
  `type_of_investment` tinyint NOT NULL,
  `company` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_funds_by_sector`
--

DROP TABLE IF EXISTS `view_funds_by_sector`;
/*!50001 DROP VIEW IF EXISTS `view_funds_by_sector`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_funds_by_sector` (
  `sectors` tinyint NOT NULL,
  `amount` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_number_of_startups_by_year`
--

DROP TABLE IF EXISTS `view_number_of_startups_by_year`;
/*!50001 DROP VIEW IF EXISTS `view_number_of_startups_by_year`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_number_of_startups_by_year` (
  `founding_date` tinyint NOT NULL,
  `number_of_companies` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_startup_country`
--

DROP TABLE IF EXISTS `view_startup_country`;
/*!50001 DROP VIEW IF EXISTS `view_startup_country`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_startup_country` (
  `id_startup` tinyint NOT NULL,
  `country` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_startup_faculty_schools`
--

DROP TABLE IF EXISTS `view_startup_faculty_schools`;
/*!50001 DROP VIEW IF EXISTS `view_startup_faculty_schools`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_startup_faculty_schools` (
  `id_startup` tinyint NOT NULL,
  `schools` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_startup_impact`
--

DROP TABLE IF EXISTS `view_startup_impact`;
/*!50001 DROP VIEW IF EXISTS `view_startup_impact`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_startup_impact` (
  `id_startup` tinyint NOT NULL,
  `impact` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_startup_with,ty_of_person_id`
--

DROP TABLE IF EXISTS `view_startup_with,ty_of_person_id`;
/*!50001 DROP VIEW IF EXISTS `view_startup_with,ty_of_person_id`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_startup_with,ty_of_person_id` (
  `id_startup` tinyint NOT NULL,
  `company` tinyint NOT NULL,
  `id_type_of_person1` tinyint NOT NULL,
  `id_type_of_person2` tinyint NOT NULL,
  `id_type_of_person3` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_startup_with_id_person`
--

DROP TABLE IF EXISTS `view_startup_with_id_person`;
/*!50001 DROP VIEW IF EXISTS `view_startup_with_id_person`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_startup_with_id_person` (
  `id_startup` tinyint NOT NULL,
  `company` tinyint NOT NULL,
  `id_startup_person1` tinyint NOT NULL,
  `id_person1` tinyint NOT NULL,
  `id_startup_person2` tinyint NOT NULL,
  `id_person2` tinyint NOT NULL,
  `id_startup_person3` tinyint NOT NULL,
  `id_person3` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_startup_with_id_type_of_person`
--

DROP TABLE IF EXISTS `view_startup_with_id_type_of_person`;
/*!50001 DROP VIEW IF EXISTS `view_startup_with_id_type_of_person`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_startup_with_id_type_of_person` (
  `id_startup` tinyint NOT NULL,
  `company` tinyint NOT NULL,
  `id_type_of_person1` tinyint NOT NULL,
  `id_type_of_person2` tinyint NOT NULL,
  `id_type_of_person3` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_startup_with_person`
--

DROP TABLE IF EXISTS `view_startup_with_person`;
/*!50001 DROP VIEW IF EXISTS `view_startup_with_person`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_startup_with_person` (
  `id_startup` tinyint NOT NULL,
  `company` tinyint NOT NULL,
  `id_startup_person1` tinyint NOT NULL,
  `id_person1` tinyint NOT NULL,
  `name1` tinyint NOT NULL,
  `firstname1` tinyint NOT NULL,
  `id_startup_person2` tinyint NOT NULL,
  `id_person2` tinyint NOT NULL,
  `name2` tinyint NOT NULL,
  `firstname2` tinyint NOT NULL,
  `id_startup_person3` tinyint NOT NULL,
  `id_person3` tinyint NOT NULL,
  `name3` tinyint NOT NULL,
  `firstname3` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_startup_with_type_of_person`
--

DROP TABLE IF EXISTS `view_startup_with_type_of_person`;
/*!50001 DROP VIEW IF EXISTS `view_startup_with_type_of_person`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_startup_with_type_of_person` (
  `id_startup` tinyint NOT NULL,
  `company` tinyint NOT NULL,
  `id_type_of_person1` tinyint NOT NULL,
  `type_of_person1` tinyint NOT NULL,
  `id_type_of_person2` tinyint NOT NULL,
  `type_of_person2` tinyint NOT NULL,
  `id_type_of_person3` tinyint NOT NULL,
  `type_of_person3` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Temporary table structure for view `view_startups_by_sector`
--

DROP TABLE IF EXISTS `view_startups_by_sector`;
/*!50001 DROP VIEW IF EXISTS `view_startups_by_sector`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE TABLE `view_startups_by_sector` (
  `sectors` tinyint NOT NULL,
  `company` tinyint NOT NULL
) ENGINE=MyISAM */;
SET character_set_client = @saved_cs_client;

--
-- Final view structure for view `view_detail_startup`
--

/*!50001 DROP TABLE IF EXISTS `view_detail_startup`*/;
/*!50001 DROP VIEW IF EXISTS `view_detail_startup`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_detail_startup` AS select `startup`.`id_startup` AS `id_startup`,`startup`.`company` AS `company`,`startup`.`web` AS `web`,`startup`.`founding_date` AS `founding_date`,`startup`.`rc` AS `rc`,`startup`.`exit_year` AS `exit_year`,`startup`.`epfl_grant` AS `epfl_grant`,`startup`.`awards_competitions` AS `awards_competitions`,`startup`.`key_words` AS `key_words`,`startup`.`laboratory` AS `laboratory`,`startup`.`short_description` AS `short_description`,`startup`.`company_uid` AS `company_uid`,`startup`.`crunchbase_uid` AS `crunchbase_uid`,`startup`.`unit_path` AS `unit_path`,`status`.`status` AS `status`,`type_startup`.`type_startup` AS `type_startup`,`sectors`.`sectors` AS `sectors`,`category`.`category` AS `category`,`ceo_education_level`.`ceo_education_level` AS `ceo_education_level` from (((((`startup` join `status` on(`status`.`id_status` = `startup`.`fk_status`)) join `type_startup` on(`type_startup`.`id_type_startup` = `startup`.`fk_type`)) left join `sectors` on(`sectors`.`id_sectors` = `startup`.`fk_sectors`)) left join `category` on(`category`.`id_category` = `startup`.`fk_category`)) left join `ceo_education_level` on(`ceo_education_level`.`id_ceo_education_level` = `startup`.`fk_ceo_education_level`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_detail_startup_full`
--

/*!50001 DROP TABLE IF EXISTS `view_detail_startup_full`*/;
/*!50001 DROP VIEW IF EXISTS `view_detail_startup_full`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_detail_startup_full` AS select `view_detail_startup`.`id_startup` AS `id_startup`,`view_detail_startup`.`company` AS `company`,`view_detail_startup`.`web` AS `web`,`view_detail_startup`.`founding_date` AS `founding_date`,`view_detail_startup`.`rc` AS `rc`,`view_detail_startup`.`exit_year` AS `exit_year`,`view_detail_startup`.`epfl_grant` AS `epfl_grant`,`view_detail_startup`.`awards_competitions` AS `awards_competitions`,`view_detail_startup`.`key_words` AS `key_words`,`view_detail_startup`.`laboratory` AS `laboratory`,`view_detail_startup`.`short_description` AS `short_description`,`view_detail_startup`.`company_uid` AS `company_uid`,`view_detail_startup`.`crunchbase_uid` AS `crunchbase_uid`,`view_detail_startup`.`unit_path` AS `unit_path`,`view_detail_startup`.`status` AS `status`,`view_detail_startup`.`type_startup` AS `type_startup`,`view_detail_startup`.`sectors` AS `sectors`,`view_detail_startup`.`category` AS `category`,`view_detail_startup`.`ceo_education_level` AS `ceo_education_level`,`view_startup_country`.`country` AS `country`,`view_startup_impact`.`impact` AS `impact`,`view_startup_faculty_schools`.`schools` AS `schools`,`view_startup_with_person`.`id_startup_person1` AS `id_startup_person1`,`view_startup_with_person`.`id_person1` AS `id_person1`,`view_startup_with_person`.`name1` AS `name1`,`view_startup_with_person`.`firstname1` AS `firstname1`,`view_startup_with_type_of_person`.`id_type_of_person1` AS `id_type_of_person1`,`view_startup_with_type_of_person`.`type_of_person1` AS `type_of_person1`,`view_startup_with_person`.`id_startup_person2` AS `id_startup_person2`,`view_startup_with_person`.`id_person2` AS `id_person2`,`view_startup_with_person`.`name2` AS `name2`,`view_startup_with_person`.`firstname2` AS `firstname2`,`view_startup_with_type_of_person`.`id_type_of_person2` AS `id_type_of_person2`,`view_startup_with_type_of_person`.`type_of_person2` AS `type_of_person2`,`view_startup_with_person`.`id_startup_person3` AS `id_startup_person3`,`view_startup_with_person`.`id_person3` AS `id_person3`,`view_startup_with_person`.`name3` AS `name3`,`view_startup_with_person`.`firstname3` AS `firstname3`,`view_startup_with_type_of_person`.`id_type_of_person3` AS `id_type_of_person3`,`view_startup_with_type_of_person`.`type_of_person3` AS `type_of_person3` from (((((`view_detail_startup` left join `view_startup_country` on(`view_detail_startup`.`id_startup` = `view_startup_country`.`id_startup`)) left join `view_startup_impact` on(`view_detail_startup`.`id_startup` = `view_startup_impact`.`id_startup`)) left join `view_startup_faculty_schools` on(`view_detail_startup`.`id_startup` = `view_startup_faculty_schools`.`id_startup`)) left join `view_startup_with_person` on(`view_detail_startup`.`id_startup` = `view_startup_with_person`.`id_startup`)) left join `view_startup_with_type_of_person` on(`view_detail_startup`.`id_startup` = `view_startup_with_type_of_person`.`id_startup`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_display_funds`
--

/*!50001 DROP TABLE IF EXISTS `view_display_funds`*/;
/*!50001 DROP VIEW IF EXISTS `view_display_funds`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_display_funds` AS select `funding`.`id_funding` AS `id_funding`,`funding`.`amount` AS `amount`,`funding`.`investment_date` AS `investment_date`,`funding`.`investors` AS `investors`,`funding`.`fk_startup` AS `fk_startup`,`stage_of_investment`.`stage_of_investment` AS `stage_of_investment`,`type_of_investment`.`type_of_investment` AS `type_of_investment`,`startup`.`company` AS `company` from (((`funding` left join `startup` on(`startup`.`id_startup` = `funding`.`fk_startup`)) left join `stage_of_investment` on(`stage_of_investment`.`id_stage_of_investment` = `funding`.`fk_stage_of_investment`)) left join `type_of_investment` on(`type_of_investment`.`id_type_of_investment` = `funding`.`fk_type_of_investment`)) order by `startup`.`company`,`funding`.`investment_date` desc */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_funds_by_sector`
--

/*!50001 DROP TABLE IF EXISTS `view_funds_by_sector`*/;
/*!50001 DROP VIEW IF EXISTS `view_funds_by_sector`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_funds_by_sector` AS select `sectors`.`sectors` AS `sectors`,sum(`funding`.`amount`) AS `amount` from ((`startup` join `funding` on(`funding`.`fk_startup` = `startup`.`id_startup`)) join `sectors` on(`sectors`.`id_sectors` = `startup`.`fk_sectors`)) group by `sectors`.`sectors` order by `sectors`.`sectors` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_number_of_startups_by_year`
--

/*!50001 DROP TABLE IF EXISTS `view_number_of_startups_by_year`*/;
/*!50001 DROP VIEW IF EXISTS `view_number_of_startups_by_year`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_unicode_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_number_of_startups_by_year` AS select `startup`.`founding_date` AS `founding_date`,count(`startup`.`company`) AS `number_of_companies` from `startup` where `startup`.`founding_date` < year(curdate()) group by `startup`.`founding_date` order by `startup`.`founding_date` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_startup_country`
--

/*!50001 DROP TABLE IF EXISTS `view_startup_country`*/;
/*!50001 DROP VIEW IF EXISTS `view_startup_country`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_startup_country` AS select `startup`.`id_startup` AS `id_startup`,group_concat(`founders_country`.`founders_country` separator ';') AS `country` from ((`startup` join `startup_founders_country` on(`startup`.`id_startup` = `startup_founders_country`.`fk_startup`)) join `founders_country` on(`founders_country`.`id_founders_country` = `startup_founders_country`.`fk_founders_country`)) group by `startup`.`id_startup` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_startup_faculty_schools`
--

/*!50001 DROP TABLE IF EXISTS `view_startup_faculty_schools`*/;
/*!50001 DROP VIEW IF EXISTS `view_startup_faculty_schools`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_startup_faculty_schools` AS select `startup`.`id_startup` AS `id_startup`,group_concat(`faculty_schools`.`faculty_schools` separator ';') AS `schools` from ((`startup` join `startup_faculty_schools` on(`startup`.`id_startup` = `startup_faculty_schools`.`fk_startup`)) join `faculty_schools` on(`faculty_schools`.`id_faculty_schools` = `startup_faculty_schools`.`fk_faculty_schools`)) group by `startup`.`id_startup` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_startup_impact`
--

/*!50001 DROP TABLE IF EXISTS `view_startup_impact`*/;
/*!50001 DROP VIEW IF EXISTS `view_startup_impact`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_startup_impact` AS select `startup`.`id_startup` AS `id_startup`,group_concat(`impact_sdg`.`impact_sdg` separator ';') AS `impact` from ((`startup` join `startup_impact_sdg` on(`startup`.`id_startup` = `startup_impact_sdg`.`fk_startup`)) join `impact_sdg` on(`impact_sdg`.`id_impact_sdg` = `startup_impact_sdg`.`fk_impact_sdg`)) group by `startup`.`id_startup` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_startup_with,ty_of_person_id`
--

/*!50001 DROP TABLE IF EXISTS `view_startup_with,ty_of_person_id`*/;
/*!50001 DROP VIEW IF EXISTS `view_startup_with,ty_of_person_id`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_startup_with,ty_of_person_id` AS select `startup`.`id_startup` AS `id_startup`,`startup`.`company` AS `company`,(select `startup_person`.`fk_type_of_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 1) AS `id_type_of_person1`,(select `startup_person`.`fk_type_of_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 1,1) AS `id_type_of_person2`,(select `startup_person`.`fk_type_of_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 2,1) AS `id_type_of_person3` from `startup` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_startup_with_id_person`
--

/*!50001 DROP TABLE IF EXISTS `view_startup_with_id_person`*/;
/*!50001 DROP VIEW IF EXISTS `view_startup_with_id_person`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_startup_with_id_person` AS select `startup`.`id_startup` AS `id_startup`,`startup`.`company` AS `company`,(select `startup_person`.`id_startup_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 1) AS `id_startup_person1`,(select `startup_person`.`fk_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 1) AS `id_person1`,(select `startup_person`.`id_startup_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 1,1) AS `id_startup_person2`,(select `startup_person`.`fk_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 1,1) AS `id_person2`,(select `startup_person`.`id_startup_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 2,1) AS `id_startup_person3`,(select `startup_person`.`fk_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 2,1) AS `id_person3` from `startup` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_startup_with_id_type_of_person`
--

/*!50001 DROP TABLE IF EXISTS `view_startup_with_id_type_of_person`*/;
/*!50001 DROP VIEW IF EXISTS `view_startup_with_id_type_of_person`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_startup_with_id_type_of_person` AS select `startup`.`id_startup` AS `id_startup`,`startup`.`company` AS `company`,(select `startup_person`.`fk_type_of_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 1) AS `id_type_of_person1`,(select `startup_person`.`fk_type_of_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 1,1) AS `id_type_of_person2`,(select `startup_person`.`fk_type_of_person` from `startup_person` where `startup`.`id_startup` = `startup_person`.`fk_startup` order by `startup_person`.`id_startup_person` limit 2,1) AS `id_type_of_person3` from `startup` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_startup_with_person`
--

/*!50001 DROP TABLE IF EXISTS `view_startup_with_person`*/;
/*!50001 DROP VIEW IF EXISTS `view_startup_with_person`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_startup_with_person` AS select `view_startup_with_id_person`.`id_startup` AS `id_startup`,`view_startup_with_id_person`.`company` AS `company`,`view_startup_with_id_person`.`id_startup_person1` AS `id_startup_person1`,`view_startup_with_id_person`.`id_person1` AS `id_person1`,`person1`.`name` AS `name1`,`person1`.`firstname` AS `firstname1`,`view_startup_with_id_person`.`id_startup_person2` AS `id_startup_person2`,`view_startup_with_id_person`.`id_person2` AS `id_person2`,`person2`.`name` AS `name2`,`person2`.`firstname` AS `firstname2`,`view_startup_with_id_person`.`id_startup_person3` AS `id_startup_person3`,`view_startup_with_id_person`.`id_person3` AS `id_person3`,`person3`.`name` AS `name3`,`person3`.`firstname` AS `firstname3` from (((`view_startup_with_id_person` left join `person` `person1` on(`view_startup_with_id_person`.`id_person1` = `person1`.`id_person`)) left join `person` `person2` on(`view_startup_with_id_person`.`id_person2` = `person2`.`id_person`)) left join `person` `person3` on(`view_startup_with_id_person`.`id_person3` = `person3`.`id_person`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_startup_with_type_of_person`
--

/*!50001 DROP TABLE IF EXISTS `view_startup_with_type_of_person`*/;
/*!50001 DROP VIEW IF EXISTS `view_startup_with_type_of_person`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_startup_with_type_of_person` AS select `view_startup_with_id_type_of_person`.`id_startup` AS `id_startup`,`view_startup_with_id_type_of_person`.`company` AS `company`,`view_startup_with_id_type_of_person`.`id_type_of_person1` AS `id_type_of_person1`,`type_of_person1`.`type_of_person` AS `type_of_person1`,`view_startup_with_id_type_of_person`.`id_type_of_person2` AS `id_type_of_person2`,`type_of_person2`.`type_of_person` AS `type_of_person2`,`view_startup_with_id_type_of_person`.`id_type_of_person3` AS `id_type_of_person3`,`type_of_person3`.`type_of_person` AS `type_of_person3` from (((`view_startup_with_id_type_of_person` left join `type_of_person` `type_of_person1` on(`view_startup_with_id_type_of_person`.`id_type_of_person1` = `type_of_person1`.`id_type_of_person`)) left join `type_of_person` `type_of_person2` on(`view_startup_with_id_type_of_person`.`id_type_of_person2` = `type_of_person2`.`id_type_of_person`)) left join `type_of_person` `type_of_person3` on(`view_startup_with_id_type_of_person`.`id_type_of_person3` = `type_of_person3`.`id_type_of_person`)) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `view_startups_by_sector`
--

/*!50001 DROP TABLE IF EXISTS `view_startups_by_sector`*/;
/*!50001 DROP VIEW IF EXISTS `view_startups_by_sector`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013  SQL SECURITY DEFINER */
/*!50001 VIEW `view_startups_by_sector` AS select `sectors`.`sectors` AS `sectors`,count(`startup`.`company`) AS `company` from (`startup` join `sectors` on(`sectors`.`id_sectors` = `startup`.`fk_sectors`)) group by `sectors`.`sectors` order by `sectors`.`sectors` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-06-23 13:09:23
