CREATE DATABASE  IF NOT EXISTS `test_organization` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `test_organization`;
-- MySQL dump 10.13  Distrib 8.0.27, for Win64 (x86_64)
--
-- Host: localhost    Database: test_organization
-- ------------------------------------------------------
-- Server version	8.0.27

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `node_tree`
--

DROP TABLE IF EXISTS `node_tree`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `node_tree` (
  `idNode` int NOT NULL,
  `level` int DEFAULT NULL,
  `iLeft` int DEFAULT NULL,
  `iRight` int DEFAULT NULL,
  PRIMARY KEY (`idNode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `node_tree`
--

LOCK TABLES `node_tree` WRITE;
/*!40000 ALTER TABLE `node_tree` DISABLE KEYS */;
INSERT INTO `node_tree` VALUES (1,2,2,3),(2,2,4,5),(3,2,6,7),(4,2,8,9),(5,1,1,24),(6,2,10,11),(7,2,12,19),(8,3,15,16),(9,3,17,18),(10,2,20,21),(11,3,13,14),(12,2,22,23);
/*!40000 ALTER TABLE `node_tree` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-16 23:34:22

--
-- Table structure for table `node_tree_names`
--

DROP TABLE IF EXISTS `node_tree_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `node_tree_names` (
  `idNode` int NOT NULL,
  `language` varchar(45) NOT NULL,
  `nodeName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idNode`,`language`),
  CONSTRAINT `idNode` FOREIGN KEY (`idNode`) REFERENCES `node_tree` (`idNode`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `node_tree_names`
--

LOCK TABLES `node_tree_names` WRITE;
/*!40000 ALTER TABLE `node_tree_names` DISABLE KEYS */;
INSERT INTO `node_tree_names` VALUES (1,'english','Marketing'),(1,'italian','Marketing'),(2,'english','Helpdesk'),(2,'italian','Supporto tecnico'),(3,'english','Managers'),(3,'italian','Managers'),(4,'english','Customer Account'),(4,'italian','Assistenza Cliente'),(5,'english','Docebo'),(5,'italian','Docebo'),(6,'english','Accounting'),(6,'italian','Amministrazione'),(7,'english','Sales'),(7,'italian','Supporto Vendite'),(8,'english','Italy'),(8,'italian','Italia'),(9,'english','Europe'),(9,'italian','Europa'),(10,'english','Developers'),(10,'italian','Sviluppatori'),(11,'english','North America'),(11,'italian','Nord America'),(12,'english','Quality Assurance'),(12,'italian','Controllo Qualità');
/*!40000 ALTER TABLE `node_tree_names` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-16 23:34:22
