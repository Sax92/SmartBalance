-- MySQL dump 10.16  Distrib 10.1.13-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: managerdb
-- ------------------------------------------------------
-- Server version	10.1.13-MariaDB

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
-- Table structure for table `clienti`
--

DROP TABLE IF EXISTS `clienti`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clienti` (
  `idCliente` int(11) NOT NULL AUTO_INCREMENT,
  `codCliente` varchar(30) NOT NULL,
  `ragSociale` varchar(60) NOT NULL,
  `citta` varchar(30) DEFAULT NULL,
  `indirizzo` varchar(50) DEFAULT NULL,
  `provincia` varchar(2) DEFAULT NULL,
  `comune` varchar(50) DEFAULT NULL,
  `CAP` varchar(10) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `pIva` varchar(20) DEFAULT NULL,
  `CF` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idCliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clienti`
--

LOCK TABLES `clienti` WRITE;
/*!40000 ALTER TABLE `clienti` DISABLE KEYS */;
/*!40000 ALTER TABLE `clienti` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detrazioni`
--

DROP TABLE IF EXISTS `detrazioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detrazioni` (
  `idDetrazione` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(80) NOT NULL,
  `tipo` varchar(20) NOT NULL,
  `importo` double NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`idDetrazione`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detrazioni`
--

LOCK TABLES `detrazioni` WRITE;
/*!40000 ALTER TABLE `detrazioni` DISABLE KEYS */;
/*!40000 ALTER TABLE `detrazioni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `entrate`
--

DROP TABLE IF EXISTS `entrate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entrate` (
  `idEntrata` int(11) NOT NULL AUTO_INCREMENT,
  `dataFattura` date NOT NULL,
  `voce` varchar(60) NOT NULL,
  `importo` double NOT NULL,
  `dataPagamento` date NOT NULL,
  `fatto` tinyint(1) NOT NULL,
  `fkCliente` int(11) NOT NULL,
  PRIMARY KEY (`idEntrata`),
  KEY `fkCliente` (`fkCliente`),
  CONSTRAINT `Entrate_ibfk_1` FOREIGN KEY (`fkCliente`) REFERENCES `clienti` (`idCliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `entrate`
--

LOCK TABLES `entrate` WRITE;
/*!40000 ALTER TABLE `entrate` DISABLE KEYS */;
/*!40000 ALTER TABLE `entrate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nomeuscita`
--

DROP TABLE IF EXISTS `nomeuscita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nomeuscita` (
  `nome` varchar(40) NOT NULL,
  `colore` varchar(20) NOT NULL,
  `categoria` varchar(30) NOT NULL,
  PRIMARY KEY (`nome`),
  KEY `categoria` (`categoria`),
  CONSTRAINT `NomeUscita_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `tipouscita` (`categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nomeuscita`
--

LOCK TABLES `nomeuscita` WRITE;
/*!40000 ALTER TABLE `nomeuscita` DISABLE KEYS */;
INSERT INTO `nomeuscita` VALUES ('ProvaVoce','#64c437','provaCat');
/*!40000 ALTER TABLE `nomeuscita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipo_detrazioni`
--

DROP TABLE IF EXISTS `tipo_detrazioni`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipo_detrazioni` (
  `nomeDet` varchar(80) NOT NULL,
  PRIMARY KEY (`nomeDet`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipo_detrazioni`
--

LOCK TABLES `tipo_detrazioni` WRITE;
/*!40000 ALTER TABLE `tipo_detrazioni` DISABLE KEYS */;
/*!40000 ALTER TABLE `tipo_detrazioni` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipouscita`
--

DROP TABLE IF EXISTS `tipouscita`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tipouscita` (
  `categoria` varchar(30) NOT NULL,
  `colore` varchar(20) NOT NULL,
  PRIMARY KEY (`categoria`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipouscita`
--

LOCK TABLES `tipouscita` WRITE;
/*!40000 ALTER TABLE `tipouscita` DISABLE KEYS */;
INSERT INTO `tipouscita` VALUES ('provaCat','#00AABB');
/*!40000 ALTER TABLE `tipouscita` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `uscite`
--

DROP TABLE IF EXISTS `uscite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `uscite` (
  `idUscita` int(11) NOT NULL AUTO_INCREMENT,
  `dataFattura` date NOT NULL,
  `voce` varchar(60) NOT NULL,
  `importo` double NOT NULL,
  `dataPagamento` date NOT NULL,
  `categoria` varchar(30) NOT NULL,
  `fatta` tinyint(1) NOT NULL,
  PRIMARY KEY (`idUscita`),
  KEY `categoria` (`categoria`),
  KEY `voce` (`voce`),
  CONSTRAINT `Uscite_ibfk_1` FOREIGN KEY (`categoria`) REFERENCES `tipouscita` (`categoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `Uscite_ibfk_2` FOREIGN KEY (`voce`) REFERENCES `nomeuscita` (`nome`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `uscite`
--

LOCK TABLES `uscite` WRITE;
/*!40000 ALTER TABLE `uscite` DISABLE KEYS */;
INSERT INTO `uscite` VALUES (9,'2016-07-18','ProvaVoce',40,'2016-07-18','provaCat',1);
/*!40000 ALTER TABLE `uscite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(40) NOT NULL,
  `cognome` varchar(60) NOT NULL,
  `email` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `citta` varchar(30) DEFAULT NULL,
  `indirizzo` varchar(50) DEFAULT NULL,
  `provincia` varchar(2) DEFAULT NULL,
  `CAP` varchar(10) DEFAULT NULL,
  `comune` varchar(50) DEFAULT NULL,
  `cellulare` varchar(10) DEFAULT NULL,
  `telefono` varchar(10) DEFAULT NULL,
  `pIva` varchar(20) DEFAULT NULL,
  `CF` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (2,'prova','prova','prova@prova','090ad5245178c11a123207f6400034b6',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
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

-- Dump completed on 2016-07-18 11:51:42
