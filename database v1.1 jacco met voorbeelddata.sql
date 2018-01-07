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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` VALUES (1,'computer'),(2,'laptop'),(3,'tablet'),(4,'smartphone'),(5,'tv'),(8,'elektra');
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
  `comp_name` varchar(45) NOT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) NOT NULL,
  `address` varchar(45) DEFAULT NULL,
  `city` varchar(45) NOT NULL,
  `email` varchar(45) DEFAULT NULL,
  `phoneNr` varchar(45) NOT NULL,
  `cellphoneNr` varchar(45) DEFAULT NULL,
  `description` varchar(1045) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `dateadded` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`customerID`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (28,'madame tussauds','hansi','hinterseer','haubtstrasse 1a','wenen','h.hinterseer@t-mobile.de','0523123456','','volkszanger uit oostenrijk',0,'2017-11-15 22:00:29'),(29,'','gerrit','vermeulen','langewijk 123','Dedemsvaart','g.vermeulen@ziggo.nl','123456','','speelt professioneel luchtgitaar ',0,'2018-12-15 22:00:29'),(30,'','jan','smit','hoofdstraat 1a','volendam','j.smit@kpnplanet.nl','123456','','',1,'2017-12-15 22:00:29'),(31,'','jacco','rieks','rheezerend 106','dedemsvaart','J.RIEKS@TEST.NL','0523611675','0636555462','jo',0,'2017-12-15 22:00:29'),(32,'langeman bouw b.v.','frederik','langeman','hoofdstraat 1a','dedemsvaart','f.langeman@langemanstaal.nl','123456','',' ',1,'2017-12-15 22:00:29'),(33,'','test','script','Dedemsvaart','dedemsvaart','test@test.nl','0332223','','test',0,'2017-12-15 22:00:29'),(34,'','test','eksp','langewijk 123','Lutten','kfdp@jajossdj','mopxfx','','mdpsmdp',0,'2017-12-15 22:00:29'),(35,'','gerrit','de boer','langewijk 123','dedemsvaart','d.deboer@sollie.nl','123456','0612345678','',1,'2017-12-15 22:00:29'),(36,'','baas','de boer','hoofdstraat 1a','testdorp','test@test.nl','05342463664','536764646','',1,'2017-12-19 19:00:37'),(37,'test','test','test','langewijk 123','dedemsvaart','test@test.nl','4455455466','35456466666','',0,'2017-12-19 21:10:06'),(38,'tet','tet','tet','rheezerend 001','dedemsvaart','test@test.nl','74867496967','4365857786','',0,'2017-12-19 21:30:21'),(39,'','test','test','hoofdstraat 1a','dedemsvaart','test@test.nl','07860686786','9567546785','',0,'2017-12-20 11:58:36');
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
INSERT INTO `customer_device` VALUES (31,10),(31,11),(30,12);
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `device`
--

LOCK TABLES `device` WRITE;
/*!40000 ALTER TABLE `device` DISABLE KEYS */;
INSERT INTO `device` VALUES (4,2,'medion 17','12345'),(5,1,'medion pc','12345'),(6,3,'samsung tab 2 10.2','sam-123'),(7,1,'medion pc','12345'),(8,2,'asus notebook','12345'),(9,1,'blablabla','sn1234'),(10,3,'sony tab','sn1234'),(11,4,'huawei troeptelefoon','sn1234'),(12,2,'lenovo y500','sn123345');
/*!40000 ALTER TABLE `device` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempt`
--

DROP TABLE IF EXISTS `login_attempt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempt` (
  `username` varchar(254) NOT NULL,
  `attempt` int(11) DEFAULT NULL,
  `time` datetime DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempt`
--

LOCK TABLES `login_attempt` WRITE;
/*!40000 ALTER TABLE `login_attempt` DISABLE KEYS */;
INSERT INTO `login_attempt` VALUES ('test@test.nl',1,'2018-01-02 12:38:11');
/*!40000 ALTER TABLE `login_attempt` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reparation`
--

LOCK TABLES `reparation` WRITE;
/*!40000 ALTER TABLE `reparation` DISABLE KEYS */;
INSERT INTO `reparation` VALUES (7,28,4,'1',1,'2017-11-07 12:03:42',0,0,0,'patrick@fixitall.nl'),(8,28,5,'is een goede kast',1,'2017-12-07 12:04:30',0,1,1,'patrick@fixitall.nl'),(9,28,4,'is weer stuk',1,'2018-01-07 12:05:05',0,0,0,'patrick@fixitall.nl'),(10,29,6,'kapot na gebruik als snijplank',1,'2017-12-07 12:22:14',0,0,0,'patrick@fixitall.nl'),(11,28,7,'jo boyzzzz',1,'2017-12-07 12:31:36',0,0,0,'test@test.nl'),(12,29,8,'scherm defect',0,'2017-12-07 14:48:55',1,1,1,'patrick@fixitall.nl'),(13,28,9,'er is een pc die kapot is blablablablaer is een pc die kapot is blablablablaer is een pc die kapot is blablablablaer is een pc die kapot is blablablablaer is een pc die kapot is blablablablaer is een pc die kapot is blablablabla',1,'2017-12-12 11:41:10',0,1,1,'patrick@fixitall.nl'),(14,31,10,'scherm defect',1,'2017-12-15 13:39:55',1,1,1,'patrick@fixitall.nl'),(15,31,11,'kapot',0,'2017-12-15 13:42:15',0,0,0,'patrick@fixitall.nl'),(18,31,11,'weer kapot',0,'2017-12-18 12:50:44',0,0,0,'patrick@fixitall.nl'),(19,30,12,'scherm kapot',1,'2017-12-21 15:08:29',1,0,0,'patrick@fixitall.nl'),(20,31,11,'brandschade',0,'2018-01-02 13:35:43',0,0,0,'patrick@fixitall.nl');
/*!40000 ALTER TABLE `reparation` ENABLE KEYS */;
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
  `function` varchar(50) NOT NULL DEFAULT 'stagiar',
  `2fa_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `2fa_secret` varchar(16) DEFAULT NULL,
  `reset_token` varchar(32) NOT NULL,
  `approved` tinyint(1) NOT NULL DEFAULT '0',
  `is_locked` tinyint(1) DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('123@test.nl','$2y$10$6uhWB1pVWs7div.8K9t0S.D8ouiDIwj6rfurzdCcqO2eSeZj6OdGO','testuser','admin',1,'JQNUVLTEB3D6H5LE','',1,0,1),('admin@admin.nl','$2y$10$DD8HASXYkgZDPSPaQ6L9leIU/ol.23QL1k2GSuX66.7sY7mO95fvm','admin','admin',0,NULL,'',1,0,0),('jacco.rieks@hotmail.com','$2y$10$hISAQ5tKmWNldRXIw0P3Yu77qKAptTDOf3PSznosnxKBeQviF5y6u','jacco rieks','admin',1,'3Q3X4JGHIVDBP2QI','b1679e1a5de5df77625f2e5151bfd13e',1,0,0),('medewerker@medewerker.nl','$2y$10$3nFGdz3AurBn.mStzlsYvOs0/BVoKZ/lnE21nle7hv926zBGnjv5u','medewerker','medewerker',0,NULL,'',1,0,0),('patrick@fixitall.nl','$2y$10$G8OJkQMewggQ8vA9dSq9BOv7vFeSSx6eCqyu.bSQNA9v0ywkV6AaC','patrick','',0,'','',1,0,1),('stagiar@stagiar.nl','$2y$10$SCEtK9SwVl0RVsVTpncTJ.nRa0igHUjazV6wAYhTcuR70TTAZWXbS','stagiar','stagiar',0,NULL,'',1,0,0),('test@test.nl','$2y$10$6sWltTE0eGD/2LKa3qrnQeBDH4O9MD1odqb4qe9Ae9AxjIPbSrK12','test','stagiar',0,'','',1,0,1);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-01-07 14:23:10
