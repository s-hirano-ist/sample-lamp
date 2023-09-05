-- MySQL dump 10.13  Distrib 5.7.43, for Linux (x86_64)
--
-- Host: localhost    Database: sample-db
-- ------------------------------------------------------
-- Server version	5.7.43

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
-- Table structure for table `member`
--

DROP TABLE IF EXISTS `member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `member` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `password` varchar(32) DEFAULT NULL,
  `name` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `zipcode` varchar(7) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `tel` varchar(13) DEFAULT NULL,
  `sex` int(11) DEFAULT NULL,
  `birthyear` int(11) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `member`
--

LOCK TABLES `member` WRITE;
/*!40000 ALTER TABLE `member` DISABLE KEYS */;
INSERT INTO `member` VALUES (1,'2023-08-23 05:35:11','70e3f54b4d870a58aed82bc04d58e897','Soraki Hirano','sorakihirano2@gmail.com','5600000','toyonaka','2001003860839',2,1990),(2,'2023-08-26 09:18:28','70e3f54b4d870a58aed82bc04d58e897','Soraki Hirano','sorakihirano2@gmail.com','5601111','aaa','2001003860839',2,1980),(3,'2023-08-26 10:05:59','6512bd43d9caa6e02c990b0a82652dca','buroccoli','sorakihirano2@gmail.com','5601111','111','2001003860839',2,1980);
/*!40000 ALTER TABLE `member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_product`
--

DROP TABLE IF EXISTS `mst_product`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_product` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `image_path` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_product`
--

LOCK TABLES `mst_product` WRITE;
/*!40000 ALTER TABLE `mst_product` DISABLE KEYS */;
INSERT INTO `mst_product` VALUES (2,'buroccoli',1000,'broccoli.jpg'),(5,'aspara',100,'aspara.jpg'),(6,'horenso',100,'horenso.jpg'),(7,'a',100,'');
/*!40000 ALTER TABLE `mst_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mst_staff`
--

DROP TABLE IF EXISTS `mst_staff`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mst_staff` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(15) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mst_staff`
--

LOCK TABLES `mst_staff` WRITE;
/*!40000 ALTER TABLE `mst_staff` DISABLE KEYS */;
INSERT INTO `mst_staff` VALUES (4,'Taro Okamoto2','47bce5c74f589f4867dbd57e9ca9f808'),(6,'sample taro','c4ca4238a0b923820dcc509a6f75849b'),(7,'sola','668a86bca62c3f12295f2a7431562314'),(8,'sample staff 4','47bce5c74f589f4867dbd57e9ca9f808');
/*!40000 ALTER TABLE `mst_staff` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales`
--

DROP TABLE IF EXISTS `sales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `code_member` int(11) DEFAULT NULL,
  `name` varchar(15) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `zipcode` varchar(7) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `tel` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales`
--

LOCK TABLES `sales` WRITE;
/*!40000 ALTER TABLE `sales` DISABLE KEYS */;
INSERT INTO `sales` VALUES (1,'2023-08-23 04:51:27',0,'Soraki Hirano','sorakihirano2@gmail.com','5600055','Toyonaka','2001003860839'),(2,'2023-08-23 04:56:44',0,'Soraki Hirano','sorakihirano2@gmail.com','5600055','Toyonaka','2001003860839'),(3,'2023-08-23 04:57:01',0,'Soraki Hirano','sorakihirano2@gmail.com','5600055','Toyonaka','2001003860839'),(4,'2023-08-23 04:57:16',0,'Soraki Hirano','sorakihirano2@gmail.com','5601111','ttt','2001003860839'),(5,'2023-08-23 05:33:16',0,'Soraki Hirano','sorakihirano2@gmail.com','5600000','Toyonaka','2001003860839'),(6,'2023-08-23 05:35:11',1,'Soraki Hirano','sorakihirano2@gmail.com','5600000','toyonaka','2001003860839'),(7,'2023-08-23 05:47:33',1,'Soraki Hirano','sorakihirano2@gmail.com','5600000','toyonaka','2001003860839'),(8,'2023-08-23 05:47:42',1,'Soraki Hirano','sorakihirano2@gmail.com','5600000','toyonaka','2001003860839'),(9,'2023-08-23 05:48:02',1,'Soraki Hirano','sorakihirano2@gmail.com','5600000','toyonaka','2001003860839'),(10,'2023-08-26 08:58:12',1,'Soraki Hirano','sorakihirano2@gmail.com','5600000','toyonaka','2001003860839'),(11,'2023-08-26 09:18:05',1,'Soraki Hirano','sorakihirano2@gmail.com','5600000','toyonaka','2001003860839'),(12,'2023-08-26 09:18:28',2,'Soraki Hirano','sorakihirano2@gmail.com','5601111','aaa','2001003860839'),(13,'2023-08-26 10:05:59',3,'buroccoli','sorakihirano2@gmail.com','5601111','111','2001003860839');
/*!40000 ALTER TABLE `sales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_detail`
--

DROP TABLE IF EXISTS `sales_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_detail` (
  `code` int(11) NOT NULL AUTO_INCREMENT,
  `code_sales` int(11) DEFAULT NULL,
  `code_product` int(11) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_detail`
--

LOCK TABLES `sales_detail` WRITE;
/*!40000 ALTER TABLE `sales_detail` DISABLE KEYS */;
INSERT INTO `sales_detail` VALUES (1,1,6,100,1),(2,1,5,100,1),(3,2,6,100,1),(4,2,5,100,1),(5,3,6,100,1),(6,3,5,100,1),(7,4,6,100,1),(8,4,5,100,1),(9,5,6,100,1),(10,5,5,100,1),(11,6,6,100,1),(12,6,5,100,1),(13,7,2,1000,1),(14,8,2,1000,1),(15,9,6,100,1),(16,11,6,100,1),(17,12,2,1000,1),(18,13,2,1000,2);
/*!40000 ALTER TABLE `sales_detail` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-09-05  8:34:14
