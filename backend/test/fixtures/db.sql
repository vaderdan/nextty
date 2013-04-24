-- MySQL dump 10.13  Distrib 5.1.41, for pc-linux-gnu (i686)
--
-- Host: localhost    Database: happy_flatsharing
-- ------------------------------------------------------
-- Server version	5.1.41

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
-- Table structure for table `bills`
--

DROP TABLE IF EXISTS `bills`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `title` int(11) NOT NULL,
  `cost` double(10,4) NOT NULL,
  `users_id` int(4) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills`
--

LOCK TABLES `bills` WRITE;
/*!40000 ALTER TABLE `bills` DISABLE KEYS */;
INSERT INTO `bills` VALUES (1,0,0.0000,0);
/*!40000 ALTER TABLE `bills` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bills_users`
--

DROP TABLE IF EXISTS `bills_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bills_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cost` double(10,4) NOT NULL,
  `users_id` int(11) unsigned DEFAULT NULL,
  `bills_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_328ba7c09592ffaed1813f8291fadaa6422a39b0` (`bills_id`,`users_id`),
  KEY `index_for_bills_users_users_id` (`users_id`),
  KEY `index_for_bills_users_bills_id` (`bills_id`),
  CONSTRAINT `bills_users_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bills_users`
--

LOCK TABLES `bills_users` WRITE;
/*!40000 ALTER TABLE `bills_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `bills_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `calendar`
--

DROP TABLE IF EXISTS `calendar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` datetime NOT NULL,
  `title` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `location` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `repeat` int(2) unsigned NOT NULL,
  `notes` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `calendar_users`
--

DROP TABLE IF EXISTS `calendar_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `calendar_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(11) unsigned DEFAULT NULL,
  `calendar_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_3d7a7025c0e79cfc9a5669f62571fa2aae56e9f9` (`calendar_id`,`users_id`),
  KEY `index_for_calendar_users_users_id` (`users_id`),
  KEY `index_for_calendar_users_calendar_id` (`calendar_id`),
  CONSTRAINT `calendar_users_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `calendar_users_ibfk_2` FOREIGN KEY (`calendar_id`) REFERENCES `calendar` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `calendar_users`
--

LOCK TABLES `calendar_users` WRITE;
/*!40000 ALTER TABLE `calendar_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `calendar_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mytasks`
--

DROP TABLE IF EXISTS `mytasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mytasks` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(4) unsigned NOT NULL,
  `title` varchar(400) COLLATE utf8_unicode_ci NOT NULL,
  `body` text COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('todo','doing','done') COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mytasks`
--

LOCK TABLES `mytasks` WRITE;
/*!40000 ALTER TABLE `mytasks` DISABLE KEYS */;
INSERT INTO `mytasks` VALUES (1,0,'3333','333','todo'),(2,0,'33','33','todo'),(4,0,'33','33','todo'),(5,0,'11','11','todo'),(6,0,'','','todo'),(7,0,'123','333','todo'),(8,0,'33','33','todo'),(9,0,'##','##','todo'),(10,0,'$$','$$','todo'),(11,0,'----','','todo'),(12,0,'@@@@','','todo'),(13,0,'zzzz','','todo'),(14,0,'????','','todo'),(15,0,'danny','asdasd','todo'),(16,0,'qqqqq','','todo'),(17,0,'','asdasd','todo'),(19,0,'333','33','todo'),(20,0,'racho','##','todo'),(21,0,'gaga','##','todo'),(22,0,'##','##','todo'),(23,0,'##','##','todo'),(24,0,'rab','','todo'),(25,0,'','','todo'),(26,0,'assss','','todo'),(27,0,'%%%%','','todo'),(28,0,'GGGG','','todo'),(29,0,'AAAA','','todo'),(30,0,'RRRRR','','todo'),(31,0,'RRRRR','','todo'),(32,0,'RRRRR','ass','todo'),(33,0,'----','','todo'),(34,0,'danny','asdasd','todo'),(35,0,'RRRRR','','todo'),(36,0,'@','','todo'),(37,0,'RRRRR','ass','todo'),(38,0,'R1','ass','todo'),(39,0,'zzzz2','eewrwe','todo'),(40,0,'$$','$$','todo'),(41,0,'','','todo'),(42,0,'asdasd','','todo'),(43,0,'----','','todo'),(44,0,'','','todo'),(45,0,'@@@@','','todo');
/*!40000 ALTER TABLE `mytasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mytasks_users`
--

DROP TABLE IF EXISTS `mytasks_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mytasks_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `users_id` int(11) unsigned DEFAULT NULL,
  `mytasks_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_517938febab15574aa15ec91db59c2987ab8b45e` (`mytasks_id`,`users_id`),
  KEY `index_for_mytasks_users_users_id` (`users_id`),
  KEY `index_for_mytasks_users_mytasks_id` (`mytasks_id`),
  CONSTRAINT `mytasks_users_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `mytasks_users_ibfk_2` FOREIGN KEY (`mytasks_id`) REFERENCES `mytasks` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mytasks_users`
--

LOCK TABLES `mytasks_users` WRITE;
/*!40000 ALTER TABLE `mytasks_users` DISABLE KEYS */;
INSERT INTO `mytasks_users` VALUES (24,7,45);
/*!40000 ALTER TABLE `mytasks_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `facebook_id` bigint(20) DEFAULT NULL,
  `name` varchar(400) COLLATE utf8_unicode_ci DEFAULT NULL,
  `balance` double(10,4) NOT NULL DEFAULT '0.0000',
  `first_login` int(2) unsigned NOT NULL DEFAULT '1',
  `color` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `facebook_id_2` (`facebook_id`),
  KEY `facebook_id` (`facebook_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,100000417827788,'Danny Lazarow2',0.0000,1,'#49F2A9'),(7,100002475605409,'Константин Костов',0.0000,1,'#F2BA49');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_users`
--

DROP TABLE IF EXISTS `users_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('disabled','confirmed') COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `users_id` int(11) unsigned DEFAULT NULL,
  `users2_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UQ_8263cf25bc9a747942559a96caf456e68bfd93c1` (`users2_id`,`users_id`),
  KEY `index_for_users_users_users_id` (`users_id`),
  KEY `index_for_users_users_users2_id` (`users2_id`),
  CONSTRAINT `users_users_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `users_users_ibfk_2` FOREIGN KEY (`users2_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_users`
--

LOCK TABLES `users_users` WRITE;
/*!40000 ALTER TABLE `users_users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users_users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-02-06 23:26:34
