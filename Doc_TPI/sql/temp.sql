CREATE DATABASE  IF NOT EXISTS `jannonce_db` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `jannonce_db`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: jannonce_db
-- ------------------------------------------------------
-- Server version	5.6.15-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `adress`
--

DROP TABLE IF EXISTS `adress`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `adress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(50) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `country_iso` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_adress_country1_idx` (`country_iso`),
  CONSTRAINT `fk_adress_country1` FOREIGN KEY (`country_iso`) REFERENCES `country` (`iso`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `adress_view`
--

DROP TABLE IF EXISTS `adress_view`;
/*!50001 DROP VIEW IF EXISTS `adress_view`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `adress_view` AS SELECT 
 1 AS `id`,
 1 AS `city`,
 1 AS `street`,
 1 AS `country`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `price` varchar(45) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `creationdate` datetime NOT NULL,
  `banned` tinyint(1) NOT NULL,
  `id_Users` int(11) NOT NULL,
  `mailvisible` tinyint(1) NOT NULL,
  `phonevisible` tinyint(1) NOT NULL,
  `adressvisible` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_articles_id_Users` (`id_Users`),
  CONSTRAINT `FK_articles_id_Users` FOREIGN KEY (`id_Users`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `comments`
--

DROP TABLE IF EXISTS `comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_Users` int(11) NOT NULL,
  `id_articles` int(11) NOT NULL,
  `date_com` datetime NOT NULL,
  `comm` text NOT NULL,
  `state` tinyint(1) NOT NULL,
  `banned` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Comments_id_articles_idx` (`id_articles`),
  KEY `id_user_idx` (`id_Users`),
  CONSTRAINT `id_articles` FOREIGN KEY (`id_articles`) REFERENCES `articles` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `id_user` FOREIGN KEY (`id_Users`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `country`
--

DROP TABLE IF EXISTS `country`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `country` (
  `iso` varchar(2) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`iso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dummy`
--

DROP TABLE IF EXISTS `dummy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dummy` (
  `idtest` int(11) NOT NULL AUTO_INCREMENT,
  `test` varchar(45) NOT NULL,
  PRIMARY KEY (`idtest`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(100) NOT NULL,
  `id_articles` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Images_id_articles` (`id_articles`),
  CONSTRAINT `FK_Images_id_articles` FOREIGN KEY (`id_articles`) REFERENCES `articles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Temporary view structure for view `user_info`
--

DROP TABLE IF EXISTS `user_info`;
/*!50001 DROP VIEW IF EXISTS `user_info`*/;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
/*!50001 CREATE VIEW `user_info` AS SELECT 
 1 AS `id`,
 1 AS `firstname`,
 1 AS `lastname`,
 1 AS `gender`,
 1 AS `mail`,
 1 AS `phone`,
 1 AS `banned`,
 1 AS `password`,
 1 AS `privilege`,
 1 AS `path`,
 1 AS `country`,
 1 AS `city`,
 1 AS `street`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` char(25) NOT NULL,
  `lastname` char(25) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `mail` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `banned` tinyint(1) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `id_Images` int(11) NOT NULL,
  `id_Adress` int(11) NOT NULL,
  `privilege` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail` (`mail`),
  KEY `FK_Users_id_Images` (`id_Images`),
  KEY `FK_Users_id_Adress` (`id_Adress`),
  CONSTRAINT `FK_Users_id_Adress` FOREIGN KEY (`id_Adress`) REFERENCES `adress` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_Users_id_Images` FOREIGN KEY (`id_Images`) REFERENCES `images` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Final view structure for view `adress_view`
--

/*!50001 DROP VIEW IF EXISTS `adress_view`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `adress_view` AS select `adress`.`id` AS `id`,`adress`.`city` AS `city`,`adress`.`street` AS `street`,`country`.`name` AS `country` from (`adress` join `country`) where (`adress`.`country_iso` = `country`.`iso`) */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;

--
-- Final view structure for view `user_info`
--

/*!50001 DROP VIEW IF EXISTS `user_info`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8 */;
/*!50001 SET character_set_results     = utf8 */;
/*!50001 SET collation_connection      = utf8_general_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `user_info` AS select `users`.`id` AS `id`,`users`.`firstname` AS `firstname`,`users`.`lastname` AS `lastname`,`users`.`gender` AS `gender`,`users`.`mail` AS `mail`,`users`.`phone` AS `phone`,`users`.`banned` AS `banned`,`users`.`password` AS `password`,`users`.`privilege` AS `privilege`,`images`.`path` AS `path`,`adress_view`.`country` AS `country`,`adress_view`.`city` AS `city`,`adress_view`.`street` AS `street` from ((`users` join `images`) join `adress_view`) where ((`users`.`id_Images` = `images`.`id`) and (`users`.`id_Adress` = `adress_view`.`id`)) */;
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

-- Dump completed on 2016-06-08  8:45:05
