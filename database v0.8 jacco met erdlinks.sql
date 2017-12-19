CREATE DATABASE  IF NOT EXISTS `mydb2` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mydb2`;
-- MySQL dump 10.13  Distrib 5.6.24, for Win64 (x86_64)
--
-- Host: localhost    Database: mydb2
-- ------------------------------------------------------
-- Server version	5.5.5-10.1.26-MariaDB

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
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`categoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'computer'),(2,'laptop'),(3,'tablet'),(4,'smartphone');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `customerID` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  `city` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phoneNr` varchar(45) NOT NULL,
  `cellphoneNr` varchar(45) DEFAULT NULL,
  `description` varchar(1045) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`customerID`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (28,'hansi','hinterseer','haubtstrasse 1a','wenen','h.hinterseer@t-mobile.de','0523123456','','',1),(29,'gerrit','vermeulen','langewijk 123','Dedemsvaart','g.vermeulen@ziggo.nl','123456','','',1);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_device`
--

DROP TABLE IF EXISTS `customer_device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_device` (
  `customerID` int(11) NOT NULL,
  `deviceID` int(11) NOT NULL,
  KEY `customerID` (`customerID`),
  KEY `deviceID` (`deviceID`),
  CONSTRAINT `customer_device_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`),
  CONSTRAINT `customer_device_ibfk_2` FOREIGN KEY (`deviceID`) REFERENCES `device` (`deviceID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_device`
--

LOCK TABLES `customer_device` WRITE;
/*!40000 ALTER TABLE `customer_device` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `device`
--

DROP TABLE IF EXISTS `device`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `device` (
  `deviceID` int(11) NOT NULL AUTO_INCREMENT,
  `categoryID` int(11) NOT NULL,
  `deviceInfo` varchar(500) DEFAULT NULL,
  `serialnr` varchar(20) NOT NULL,
  PRIMARY KEY (`deviceID`,`categoryID`),
  KEY `fk_Apparaat_Categorie1_idx` (`categoryID`),
  CONSTRAINT `fk_Apparaat_Categorie1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device`
--

LOCK TABLES `device` WRITE;
/*!40000 ALTER TABLE `device` DISABLE KEYS */;
INSERT INTO `device` VALUES (4,2,'medion 17','12345'),(5,1,'medion pc','12345'),(6,3,'samsung tab 2 10.2','sam-123');
/*!40000 ALTER TABLE `device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `permissions` (
  `perm_id` int(10) NOT NULL,
  `perm_desc` varchar(50) NOT NULL,
  PRIMARY KEY (`perm_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reparation`
--

DROP TABLE IF EXISTS `reparation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reparation` (
  `repairID` int(11) NOT NULL AUTO_INCREMENT,
  `customerID` int(11) NOT NULL,
  `deviceID` int(11) NOT NULL,
  `description` varchar(535) NOT NULL,
  `chargerIncluded` tinyint(1) NOT NULL,
  `daterepair` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `finished` tinyint(1) DEFAULT '0',
  `checked` tinyint(1) NOT NULL DEFAULT '0',
  `repairedBy` varchar(45) NOT NULL DEFAULT 'patrick@fixitall.nl',
  PRIMARY KEY (`repairID`,`customerID`,`deviceID`,`repairedBy`),
  KEY `fk_Reparatie_Apparaat1_idx` (`deviceID`),
  KEY `fk_Reparatie_Klant1_idx` (`customerID`),
  KEY `fk_reparation_user1_idx` (`repairedBy`),
  CONSTRAINT `fk_Reparatie_Apparaat1` FOREIGN KEY (`deviceID`) REFERENCES `device` (`deviceID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Reparatie_Klant1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`customerID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_reparation_user1` FOREIGN KEY (`repairedBy`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reparation`
--

LOCK TABLES `reparation` WRITE;
/*!40000 ALTER TABLE `reparation` DISABLE KEYS */;
INSERT INTO `reparation` VALUES (7,28,4,'1',1,'2017-12-07 12:03:42',1,0,0,'patrick@fixitall.nl'),(8,28,5,'is een goede kast',1,'2017-12-07 12:04:30',1,0,0,'patrick@fixitall.nl'),(9,28,4,'is weer stuk',1,'2017-12-07 12:05:05',1,0,0,'patrick@fixitall.nl'),(10,29,6,'kapot na gebruik als snijplank',1,'2017-12-07 12:22:14',1,0,0,'patrick@fixitall.nl');
/*!40000 ALTER TABLE `reparation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role`
--

DROP TABLE IF EXISTS `role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `role_id` int(10) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_perm`
--

DROP TABLE IF EXISTS `role_perm`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role_perm` (
  `role_id` int(10) NOT NULL,
  `perm_id` int(10) NOT NULL,
  KEY `fk_role_perm_role1_idx` (`role_id`),
  KEY `fk_role_perm_permissions1_idx` (`perm_id`),
  CONSTRAINT `fk_role_perm_permissions1` FOREIGN KEY (`perm_id`) REFERENCES `permissions` (`perm_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_role_perm_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_perm`
--

LOCK TABLES `role_perm` WRITE;
/*!40000 ALTER TABLE `role_perm` DISABLE KEYS */;
/*!40000 ALTER TABLE `role_perm` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `username` varchar(45) NOT NULL,
  `password` varchar(90) NOT NULL,
  `name` varchar(45) NOT NULL,
  `role` varchar(45) NOT NULL,
  `function` varchar(50) NOT NULL DEFAULT 'stagiar',
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `2fa_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `2fa_secret` varchar(16) NOT NULL,
  `reset_token` varchar(32) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('patrick@fixitall.nl','12345','patrick','stagiar','stagiar',0,0,'','');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `user_id` varchar(45) NOT NULL,
  `role_id` int(10) NOT NULL,
  KEY `fk_user_role_user1_idx` (`user_id`),
  KEY `fk_user_role_role1_idx` (`role_id`),
  CONSTRAINT `fk_user_role_role1` FOREIGN KEY (`role_id`) REFERENCES `role` (`role_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_role_user1` FOREIGN KEY (`user_id`) REFERENCES `user` (`username`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-07 12:23:47
