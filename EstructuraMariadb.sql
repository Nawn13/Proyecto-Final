-- MariaDB dump 10.19-11.3.0-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: Empresa
-- ------------------------------------------------------
-- Server version	11.3.0-MariaDB

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
-- Table structure for table `archivos`
--

DROP TABLE IF EXISTS `archivos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `archivos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `file_id` varchar(255) DEFAULT NULL,
  `result` varchar(50) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archivos`
--

LOCK TABLES `archivos` WRITE;
/*!40000 ALTER TABLE `archivos` DISABLE KEYS */;
/*!40000 ALTER TABLE `archivos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departamentos` (
  `Id_Depart` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`Id_Depart`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departamentos`
--

LOCK TABLES `departamentos` WRITE;
/*!40000 ALTER TABLE `departamentos` DISABLE KEYS */;
INSERT INTO `departamentos` VALUES
(1,'Informatica');
/*!40000 ALTER TABLE `departamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ficheros`
--

DROP TABLE IF EXISTS `ficheros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ficheros` (
  `Id_Ficher` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Ruta` varchar(100) DEFAULT NULL,
  `Id_user` int(11) DEFAULT NULL,
  `Id_Depart` int(11) DEFAULT NULL,
  `Id_virustotal` varchar(100) DEFAULT NULL,
  `Malicioso_no` bit(1) DEFAULT NULL,
  `Hash` varchar(100) DEFAULT NULL,
  `Cant_anti` int(11) DEFAULT NULL,
  `Estado` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`Id_Ficher`),
  KEY `fk_FichUsu` (`Id_user`),
  KEY `fk_Ficher_Depart` (`Id_Depart`),
  CONSTRAINT `fk_FichUsu` FOREIGN KEY (`Id_user`) REFERENCES `usuarios` (`Id_user`),
  CONSTRAINT `fk_Ficher_Depart` FOREIGN KEY (`Id_Depart`) REFERENCES `departamentos` (`Id_Depart`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ficheros`
--

LOCK TABLES `ficheros` WRITE;
/*!40000 ALTER TABLE `ficheros` DISABLE KEYS */;
INSERT INTO `ficheros` VALUES
(38,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMDYxOQ==','\0','hash_value',3,'Clean'),
(39,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(40,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMDYxOQ==','\0','hash_value',3,'Clean'),
(41,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(42,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMDYxOQ==','\0','hash_value',3,'Clean'),
(43,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(44,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(45,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(46,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(47,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(48,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(49,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(50,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(51,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(52,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(53,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(54,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(55,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(56,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(57,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(58,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(59,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMTE2Nw==','\0','hash_value',3,'Clean'),
(60,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0',NULL,NULL,'Clean'),
(61,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(62,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(63,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(64,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(65,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMTUyNA==','\0','hash_value',3,'Clean'),
(66,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(67,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMjQ1OQ==','\0','hash_value',3,'Clean'),
(68,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(69,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMjQ1OQ==','\0','hash_value',3,'Clean'),
(70,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(71,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMjQ1OQ==','\0','hash_value',3,'Clean'),
(72,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(73,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMjQ1OQ==','\0','hash_value',3,'Clean'),
(74,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(75,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMjQ1OQ==','\0','hash_value',3,'Clean'),
(76,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(77,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMjQ1OQ==','\0','hash_value',3,'Clean'),
(78,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(79,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMjQ1OQ==','\0','hash_value',3,'Clean'),
(80,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(81,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMjQ1OQ==','\0',NULL,NULL,'Clean'),
(82,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0',NULL,NULL,'Clean'),
(83,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMjQ1OQ==','\0','hash_value',3,'Clean'),
(84,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0','hash_value',3,'Clean'),
(85,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzAxMjQ1OQ==','\0',NULL,NULL,'Clean'),
(86,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzAxMjE2Nw==','\0',NULL,NULL,'Clean'),
(87,'ho.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\ho.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzA2MjI0OA==','\0',NULL,NULL,'Clean'),
(88,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzA2MjI0OQ==','\0',NULL,NULL,'Clean'),
(89,'buenas.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\buenas.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzA2MjI0OA==','\0',NULL,NULL,'Clean'),
(90,'buenas.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\buenas.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzA2MjI0OA==','\0',NULL,NULL,'Clean'),
(91,'buenas.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\buenas.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzA2MjI0OA==','\0',NULL,NULL,'Clean'),
(92,'quetal.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\quetal.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzA2MjI0OA==','\0',NULL,NULL,'Clean'),
(93,'Mis proyectos.pdf','C:\\xampp\\htdocs\\pagina\\cuarentena\\Mis proyectos.pdf',1,1,'OWFkNjExM2I4MTE3MjU3OWNjOWVhMmY3OGNjNDRiZDQ6MTcwMzA4MTExOQ==','\0',NULL,NULL,'Clean'),
(94,'prueba.rar','C:\\xampp\\htdocs\\pagina\\cuarentena\\prueba.rar',1,1,'Yjg4N2FmMzM1ODcxMDgzNjQyOGY1NzU2MGUyMzBkMDc6MTcwMzA4MzI3Mg==','\0',NULL,NULL,'Clean'),
(95,'mmora.txt','C:\\xampp\\htdocs\\pagina\\cuarentena\\mmora.txt',1,1,'ZDQxZDhjZDk4ZjAwYjIwNGU5ODAwOTk4ZWNmODQyN2U6MTcwMzA4NTk5OQ==','\0',NULL,NULL,'Clean');
/*!40000 ALTER TABLE `ficheros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `Id_user` int(11) NOT NULL AUTO_INCREMENT,
  `Nombre` varchar(50) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `Id_Depart` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_user`),
  KEY `fk_type` (`Id_Depart`),
  CONSTRAINT `fk_type` FOREIGN KEY (`Id_Depart`) REFERENCES `departamentos` (`Id_Depart`)
) ENGINE=InnoDB AUTO_INCREMENT=109 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES
(1,'Pablo','user',NULL),
(100,'Admin','user',NULL),
(101,'Prueba','$2y$10$mEBTqesWvdvg22Y9jwHtau4/L/wieUt5Osp4BUoOOZ5lBasknPeS.',NULL),
(102,'Prueba2','$2y$10$vst.zLL9gvDtoW0YamEuy.pdpJLF1Jgw7WQwKkEM2gKzV5cyHO86u',1),
(103,'Prueba3','$2y$10$v7Fx1E7r2aFHouJ/KjD.8eE4uTZg6KWljnwDC9WeR2hKyEiIhbQxS',1),
(104,'Prueba4','$2y$10$LBOz1JLwLELz9Kesm4iQFOZevn6b4aW5zx9jRr0VQ3viBrsLEmD7W',NULL),
(105,'Prueba5','$2y$10$X0RyhFEF0ibvnd.lal2W6ex8zQ6pGxRwqDKjSH.zSawJB7obcaySS',1),
(106,'david','$2y$10$jaSU0M.dxApdI5roA4wiaeYTQGoV5zKzySNUeb0CXCdyFzv0OrkZ.',1),
(107,'Mora','$2y$10$i2Pe7Xt9cRzZgBSsB0Kl7uFCjSKXg7tOicgaLtBvu/L7Z6gf8r.Fy',1),
(108,'sergi','$2y$10$m5w29wrjtEai9aoSqdluyulRHWaJHmmrsEJQ/8VKAfLvXCiRvkfb6',NULL);
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-12-20 17:10:16
