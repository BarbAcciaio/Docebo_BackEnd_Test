CREATE DATABASE  IF NOT EXISTS `test_organization` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `test_organization`;

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
