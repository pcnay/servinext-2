-- MySQL dump 10.17  Distrib 10.3.18-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ordenservicios
-- ------------------------------------------------------
-- Server version	10.3.18-MariaDB-0+deb10u1

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
-- Table structure for table `t_Clientes`
--

DROP TABLE IF EXISTS `t_Clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Clientes` (
  `id_clientes` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  PRIMARY KEY (`id_clientes`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Clientes`
--

LOCK TABLES `t_Clientes` WRITE;
/*!40000 ALTER TABLE `t_Clientes` DISABLE KEYS */;
INSERT INTO `t_Clientes` VALUES (1,'Banamex'),(2,'Nacional Monte De Piedad'),(3,'BBVA Bancomer');
/*!40000 ALTER TABLE `t_Clientes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Detalle_historico_epo`
--

DROP TABLE IF EXISTS `t_Detalle_historico_epo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Detalle_historico_epo` (
  `id_detalle_historial` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_historico_epo` int(10) unsigned NOT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `notas` text DEFAULT NULL,
  PRIMARY KEY (`id_detalle_historial`),
  KEY `id_historico_epo` (`id_historico_epo`),
  CONSTRAINT `t_Detalle_historico_epo_ibfk_1` FOREIGN KEY (`id_historico_epo`) REFERENCES `t_Historico_epo` (`id_Historico_epo`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Detalle_historico_epo`
--

LOCK TABLES `t_Detalle_historico_epo` WRITE;
/*!40000 ALTER TABLE `t_Detalle_historico_epo` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_Detalle_historico_epo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Dev_Lexmark`
--

DROP TABLE IF EXISTS `t_Dev_Lexmark`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Dev_Lexmark` (
  `id_dev_lexmark` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cantidad` int(10) unsigned NOT NULL,
  `sr` varchar(20) DEFAULT NULL,
  `fecha` datetime NOT NULL DEFAULT current_timestamp(),
  `id_refaccion` int(10) unsigned NOT NULL,
  `id_clientes` int(10) unsigned NOT NULL,
  `id_sucursal` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_dev_lexmark`),
  KEY `id_refaccion` (`id_refaccion`),
  KEY `id_clientes` (`id_clientes`),
  KEY `id_sucursal` (`id_sucursal`),
  CONSTRAINT `t_Dev_Lexmark_ibfk_1` FOREIGN KEY (`id_refaccion`) REFERENCES `t_Refaccion` (`id_refaccion`) ON UPDATE CASCADE,
  CONSTRAINT `t_Dev_Lexmark_ibfk_2` FOREIGN KEY (`id_clientes`) REFERENCES `t_Clientes` (`id_clientes`) ON UPDATE CASCADE,
  CONSTRAINT `t_Dev_Lexmark_ibfk_3` FOREIGN KEY (`id_sucursal`) REFERENCES `t_Sucursales` (`id_sucursal`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Dev_Lexmark`
--

LOCK TABLES `t_Dev_Lexmark` WRITE;
/*!40000 ALTER TABLE `t_Dev_Lexmark` DISABLE KEYS */;
/*!40000 ALTER TABLE `t_Dev_Lexmark` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Equipo`
--

DROP TABLE IF EXISTS `t_Equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Equipo` (
  `id_epo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `num_serie` varchar(45) NOT NULL,
  `num_inv` varchar(45) DEFAULT NULL,
  `num_parte` varchar(45) DEFAULT NULL,
  `existencia` int(10) unsigned NOT NULL,
  `id_tipo_componente` int(10) unsigned NOT NULL,
  `id_marca` int(10) unsigned NOT NULL,
  `id_modelo` int(10) unsigned NOT NULL,
  `comentarios` text DEFAULT NULL,
  PRIMARY KEY (`id_epo`),
  UNIQUE KEY `num_serie` (`num_serie`),
  KEY `id_tipo_componente` (`id_tipo_componente`),
  KEY `id_marca` (`id_marca`),
  KEY `id_modelo` (`id_modelo`),
  CONSTRAINT `t_Equipo_ibfk_1` FOREIGN KEY (`id_tipo_componente`) REFERENCES `t_Tipo_Componente` (`id_tipo_componente`) ON UPDATE CASCADE,
  CONSTRAINT `t_Equipo_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `t_Marca` (`id_marca`) ON UPDATE CASCADE,
  CONSTRAINT `t_Equipo_ibfk_3` FOREIGN KEY (`id_modelo`) REFERENCES `t_Modelo` (`id_modelo`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Equipo`
--

LOCK TABLES `t_Equipo` WRITE;
/*!40000 ALTER TABLE `t_Equipo` DISABLE KEYS */;
INSERT INTO `t_Equipo` VALUES (1,'7410HH348984','1040-34567','40X4598',1,1,1,1,'COMENTARIOS 40X4598'),(4,'0123456789012345','1040-34560-2','40X403459',1,4,1,2,'COMENTARIOS 40X40'),(6,'01234567890123','1040-34567','40X999999',2,2,1,1,'COMENTARIOS 2'),(8,'012345678901234','1030-3456-40','40X99X92',44,5,2,13,'COMENTARIO 44');
/*!40000 ALTER TABLE `t_Equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Historico_epo`
--

DROP TABLE IF EXISTS `t_Historico_epo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Historico_epo` (
  `id_Historico_epo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_marca` int(10) unsigned NOT NULL,
  `id_modelo` int(10) unsigned NOT NULL,
  `id_clientes` int(10) unsigned NOT NULL,
  `id_sucursal` int(10) unsigned NOT NULL,
  `id_epo` int(10) unsigned NOT NULL,
  `fecha` date NOT NULL,
  `notas` text DEFAULT NULL,
  PRIMARY KEY (`id_Historico_epo`),
  KEY `id_marca` (`id_marca`),
  KEY `id_modelo` (`id_modelo`),
  KEY `id_clientes` (`id_clientes`),
  KEY `id_sucursal` (`id_sucursal`),
  KEY `id_epo` (`id_epo`),
  CONSTRAINT `t_Historico_epo_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `t_Marca` (`id_marca`) ON UPDATE CASCADE,
  CONSTRAINT `t_Historico_epo_ibfk_2` FOREIGN KEY (`id_modelo`) REFERENCES `t_Modelo` (`id_modelo`) ON UPDATE CASCADE,
  CONSTRAINT `t_Historico_epo_ibfk_3` FOREIGN KEY (`id_clientes`) REFERENCES `t_Clientes` (`id_clientes`) ON UPDATE CASCADE,
  CONSTRAINT `t_Historico_epo_ibfk_4` FOREIGN KEY (`id_sucursal`) REFERENCES `t_Sucursales` (`id_sucursal`) ON UPDATE CASCADE,
  CONSTRAINT `t_Historico_epo_ibfk_5` FOREIGN KEY (`id_epo`) REFERENCES `t_Equipo` (`id_epo`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Historico_epo`
--

LOCK TABLES `t_Historico_epo` WRITE;
/*!40000 ALTER TABLE `t_Historico_epo` DISABLE KEYS */;
INSERT INTO `t_Historico_epo` VALUES (1,1,1,1,1,1,'2018-05-19','Campo De Notas 1'),(2,1,1,1,1,1,'2018-06-20','Campo De Notas 2'),(3,1,1,1,1,1,'2018-07-19','Campo De Notas 3');
/*!40000 ALTER TABLE `t_Historico_epo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Marca`
--

DROP TABLE IF EXISTS `t_Marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Marca` (
  `id_marca` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) NOT NULL,
  PRIMARY KEY (`id_marca`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Marca`
--

LOCK TABLES `t_Marca` WRITE;
/*!40000 ALTER TABLE `t_Marca` DISABLE KEYS */;
INSERT INTO `t_Marca` VALUES (1,'HewllwtPackard'),(2,'Dell'),(3,'Lexmark'),(4,'BIXELON'),(5,'NO APLICA');
/*!40000 ALTER TABLE `t_Marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Modelo`
--

DROP TABLE IF EXISTS `t_Modelo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Modelo` (
  `id_modelo` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) NOT NULL,
  PRIMARY KEY (`id_modelo`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Modelo`
--

LOCK TABLES `t_Modelo` WRITE;
/*!40000 ALTER TABLE `t_Modelo` DISABLE KEYS */;
INSERT INTO `t_Modelo` VALUES (1,'MX711'),(2,'MX611'),(3,'Optiplex 970'),(4,'MS510'),(5,'MS811'),(6,'MX720'),(7,'MS810'),(8,'C950'),(9,'BIXELON'),(10,'BCD-1000DG'),(11,'OPTIPLEX 9020'),(12,'NO APLICA'),(13,'P2021'),(14,'MS610'),(15,'CS820'),(16,'MX610DN'),(17,'MS410dn'),(18,'MX611dhe'),(19,'MX511dn');
/*!40000 ALTER TABLE `t_Modelo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Refaccion`
--

DROP TABLE IF EXISTS `t_Refaccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Refaccion` (
  `id_refaccion` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(80) NOT NULL,
  `num_parte` varchar(45) NOT NULL,
  `existencia` tinyint(4) DEFAULT 1,
  `fecha` date NOT NULL,
  `id_marca` int(10) unsigned NOT NULL,
  `id_modelo` int(10) unsigned NOT NULL,
  `observaciones` text DEFAULT NULL,
  `medidas` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_refaccion`),
  UNIQUE KEY `num_parte` (`num_parte`),
  KEY `id_marca` (`id_marca`),
  KEY `id_modelo` (`id_modelo`),
  CONSTRAINT `t_Refaccion_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `t_Marca` (`id_marca`) ON UPDATE CASCADE,
  CONSTRAINT `t_Refaccion_ibfk_2` FOREIGN KEY (`id_modelo`) REFERENCES `t_Modelo` (`id_modelo`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Refaccion`
--

LOCK TABLES `t_Refaccion` WRITE;
/*!40000 ALTER TABLE `t_Refaccion` DISABLE KEYS */;
INSERT INTO `t_Refaccion` VALUES (8,'MPF FEEDER  LIFT PLATE WITH CABLE','40X7598',1,'2019-12-27',3,1,'1 - OFICINA',NULL),(10,'ENSAMBLE ALIMENTACION PAPEL','41X0959',1,'2019-12-27',3,2,'OFICINA',NULL),(11,'JAM ACCESS COVER','40X8279',1,'2019-12-27',3,2,'OFICINA',NULL),(12,'PANEL BOARD CONTROL','40X9245',1,'2019-12-27',3,1,'1 - OFICINA\r\n','37 X 16 X 22'),(13,'MEDIA FEEDER ','40X7591',1,'2019-12-27',3,1,'OFICINA','23 X 13 X 19'),(14,'MEDIA ALIGNER ROLLER WIHT MPF PICK ROLL ','40X7599',2,'2019-12-27',3,1,'1 - OFICINA','23 X 13 X 19'),(15,'UPPER REDRIVER ','40X7602',2,'2019-12-27',3,1,'1 - OFICINA',NULL),(17,'PRINT HEAD','40X7597',1,'2019-12-27',3,1,'1 - OFICINA','28 X 10 X 23'),(18,'ROLL TRANSFER ','40X8393',3,'2019-12-27',3,2,'1- OFICINA\r\n2- ALMACÉN CAJA-1\r\n\r\n',NULL),(20,'BIZEL DERECHO BASE TECLADO NUMERICO','40X7865',1,'2019-12-27',3,1,'1 - OFICINA',NULL),(21,'BOTONES DE TECLADO','40X7863',1,'2019-12-27',3,1,'1 - OFICINA',NULL),(22,'HVPS','40X7578',2,'2019-12-27',3,1,'1 - OFICINA\r\n1 - ALMACÉN  ',NULL),(23,'MPF GEAR BOX COMPLETO','40X8777',2,'2019-12-27',3,2,'2 - OFICINA\r\nCHECAR A 1 LE FALTA RESORTE INCOMPLETO\r\n',NULL),(24,'FRONT IMPUT GUIDE','40X8280',1,'2019-12-27',3,2,'1 - OFICINA',NULL),(25,'MEDIA TURN GUIDE','40X7583',5,'2019-12-27',3,1,'1 - OFICINA\r\n1 - ALMACÉN CAJA 2\r\n1 - ALMACÉN CAJA 3\r\n2 - ALMACÉN\r\n',NULL),(26,'SENSOR STD BIR FULL WITH OUTPUT BIR GUIDE','40X7691',1,'2019-12-27',3,1,'1 - OFICINA\r\n',NULL),(27,'REDIVER ANSSAMBLED','40X8298',2,'2019-12-27',3,4,'1 - OFICINA 1\r\n1 - ALMACÉN CAJA 2',NULL),(31,'MPF PICKUP ROLLER AND SEPARATOR PAD','40X8295',6,'2019-12-27',3,2,'6 - OFICINA','11 X 5 X 10'),(32,'MPF PICK ROLLER','40S7600',4,'2019-12-27',3,1,'OFICINA',NULL),(33,'MPF PICK ROLLER  ASSEMBLY','40X7593',43,'2019-12-27',3,1,'2 - OFICINA\r\n41 - ALMACÉN CAJA 3','10 X 5 X 10'),(34,'CONTRACT CARTRIDGE SMART CHIP','40X8266',2,'2019-12-27',3,2,'OFICINA',NULL),(35,'CABLE CONTROL PANEL','40X9052',1,'2019-12-27',3,1,'OFICINA\r\nLES QUEDAN A ESTOS MODELOS\r\n40 x 9052 Lexmark Cable uicc MX410de MX511de MX511dte MX610de MX310dn MX511dte',NULL),(36,'HVPS CONTACT','41X1721',1,'2019-12-27',3,1,'OFICINA',NULL),(37,'SENSOR NARROW MEDIA BIN FULL','40X8050',1,'2019-12-27',3,1,'OFICINA',NULL),(38,'MEDIA PRESENT SENSOR FLAG','40X8800',1,'2019-12-27',3,2,'1 -OFICINA','11 X 5 X 10'),(39,'ADF SEPARATOR ROLLER','40X7775',1,'2019-12-27',3,1,'OFICINA',NULL),(40,'DUPLEX GEAR ASSEMBLY','40X8277',1,'2019-12-27',3,2,'OFICINA','11 X 13 X 6'),(41,'CONTROL PANEL INTERLOCK SENSOR','40X7693',1,'2019-12-27',3,1,'OFICINA',NULL),(42,'MEDIA SENSOR','41X0259',1,'2019-12-27',3,2,'OFICNA \r\nTAMBIEN LE QUEDA A LAS\r\nMX410, 511 MX610 \r\nDE NUMERO DE PARTE 41X0259',NULL),(43,'PICK  ROLLER ASSEMBLY','40X8443',32,'2019-12-27',3,2,'5 - OFICINA\r\n27 - ALMACÉN CAJA 3',NULL),(44,'TRANSFER ROLL','40X7582',2,'2019-12-27',3,1,'OFICINA','30 X 5 X 5'),(45,'HCIT SEPARATOR ROLLER','40X7713',3,'2019-12-27',3,1,'OFICINA','31 X 5 X 7'),(47,'SEPARATOR ROLL ASSEMBLY','40X8444',2,'2019-12-27',3,2,'1 - OFICINA\r\n1 - ALMACÉN CAJA 3','11 X 13 X 6'),(48,'REDRIVER ASSEMBLY','40X9082',4,'2020-01-06',3,2,'2 - ALMACÉN CAJA 1\r\n1 - ALMACEN CAJA 2\r\n1 - ALMACÉN CAJA 6',NULL),(49,'REDRIVER ASSEMBLY','40X8437',1,'2020-01-06',3,16,'1 - ALMACEN CAJA 1',NULL),(50,'FUSOR','40X8023',4,'2020-01-06',3,2,'1 - OFICINA\r\n1 - ALMACÉN CAJA 1\r\n1 - ALMACÉN CAJA 2\r\n1 - ALMACÉN CAJA 6','37 X 15 X 17'),(51,'FUSOR','40X7743',3,'2020-01-06',3,1,'1 - OFICINA\r\n1 - ALMACÉN CAJA 2\r\n1 - ALMACÉN CAJA 6','37 X 17 X 22'),(53,'ACTUAR MEDIA SIZE','40X8541',1,'2020-01-06',3,5,'1 - ALMACEN CAJA 3',NULL),(54,'MPH PICK UP ROLLER','40X7600',8,'2020-01-06',3,1,'4 - ALMACÉN CAJA 3\r\n4 - OFICINA\r\n ',NULL),(55,'HVPS CONTACT','40X1721',2,'2020-01-06',3,1,'2 - ALMACÉN CAJA 3 ',NULL),(56,'BISAGRA ADF ASSEMBLY','40X7763',1,'2020-01-06',3,1,'1 - ALMACEN CAJA 3',NULL),(57,'ADF CONTROLLER BOARD','41X1896',1,'2020-01-06',3,6,'1 - ALMACÉN CAJA 3',NULL),(58,'SVS ROLLER PLASTIC','41X2610',1,'2020-01-06',3,7,'1 - ALMACÉN CAJA 3',NULL),(59,'PRINT FEEDER','40X7662',1,'2020-01-06',3,8,'1 - ALMACÉN CAJA 3',NULL),(60,'HCIT SEPARATION ROLLER','40X1713',83,'2020-01-06',3,1,'83 - ALMACÉN CAJA 3',NULL),(61,'PANTALLA PARA CAJA REGISTRADORA','BCD-1000DG',1,'2020-01-06',4,10,'1 - ALMACÉN CAJA 4',NULL),(62,'COMPUTADORA DE ESCRITORIO','7R5PW52',1,'2020-01-06',2,11,'1 - ALMACÉN CAJA 4\r\n1 - DISCO DURO\r\n1 - MEMORIA\r\n1 - DVD',NULL),(63,'MEDIA TURN GUIDE','40X7589',2,'2020-01-06',3,1,'1 - OFICINA\r\n1 - ALMACÉN CAJA 6\r\nSE ENCUENTRA ESPACIO PARA CAJAS PEQUEÑAS\r\n',NULL),(64,'COMPUTADORA DE ESCRITORIO','17F8KS1',1,'2020-01-06',2,3,'1 - DISCO DURO CAJA 5\r\n2 - MEMORIAS SERVINEXT CAJA 5\r\n1 - PAQUETE CAMISETAS SERVINEXT OCT/19 CAJA 5\r\n',NULL),(65,'CAJA  HERRAMIENTA','CAJ-HERR',1,'2020-01-06',5,12,'CAJA - 7\r\n1 - CAJA HERRAMIENTA SERVINEXT\r\n2 - CAMISETAS DESDE 24 SEP 18\r\n2 - LOGOS HP\r\n2 - LOGOS LEXMARK\r\n1 - NTTDATA\r\n2 - PINZAS DE PUNTA\r\n2 - PINZAS DE CORTE\r\n1 - DADO 7/32 CON DESARMADOR\r\n2 - DESARMADORES PLANOS\r\n2 - DESARMADORES DE CRUZ\r\n1 - DADO 7/32 \r\n1 - MULTIMETRO\r\n1 - CAJA DE DADOS Y PUNTAS VARIAS\r\n\r\n',NULL),(66,'MONITOR','SERIAL MONT',1,'2020-01-06',2,13,'1 - ALMACÉN CAJA 8 \r\nNACIONAL MONTE DE PIEDAD \r\nPROBLEMAS CON EL BOTÓN DE ENCENDIDO',NULL),(67,'KIT MANTTO','40X9137',2,'2019-06-21',3,2,'1 - ALMACÉN\r\nPENDIENTE DE ASIGNAR\r\nNUMERO DE PARTE 40X9137\r\n1-300675233581 21/Jun/19\r\n1-299991296885 24/May/19','50 X 25 X 34'),(68,'KIT MANTTO','1-299991296885',1,'2019-05-24',3,2,'1 - ALMACÉN\r\nPENDIENTE DE ASIGNAR\r\nNUMERO DE PARTE 40X9137',NULL),(69,'KIT MANTTO','40x8433',1,'2019-07-03',3,14,'1 - ALMACÉN \r\n500540384 - STOCK SERVINEXT\r\nNUMERO DE PARTE 40X8433\r\n\r\n1-300675233581\r\n',NULL),(70,'KIT MANTTO','101558068329B601142886',1,'2019-07-03',3,14,'1 - ALMACÉN \r\n5005403843 - STOCK SERVINEXT \r\nNUMERO DE PARTE 40X8433',NULL),(71,'HVPS CONTACT','40X7121',3,'2019-06-29',3,1,'3 - ALMACÉN ',NULL),(72,'PRINT FEEDER','40X6662',1,'2019-06-25',3,8,'1 - ALMACÉN\r\nESTABA EN OFICINA DE GABRIEL SE RECOLECTO',NULL),(73,'SYSTEM BOARD ','40X9234',1,'2018-09-27',3,1,'1 - ALMACÉN ','46 X 11 X 29'),(74,'FLATBED SCANNER','40X7912',1,'2017-08-09',3,1,'1 - ALMACÉN','64 X 38 X 53'),(75,'LVPS','40X7676',1,'2018-09-27',3,1,'1 - ALMACÉN ',NULL),(76,'CABLE PANEL CONTROL','40X7873',1,'2018-09-27',3,1,'1 - ALMACÉN',NULL),(77,'FLATBED ASSEMBLY','40X9094',1,'2017-06-28',3,2,'1 -  ALMACÉN\r\nESTABA EN DE OFICINA DE GABRIEL SE RECOLECTO','56 X 28 X 50'),(78,'CATRIDGE PLUNGER','40X9148',1,'2019-12-14',3,2,'1 - ALMACÉN ',NULL),(79,'ACM ENSAMBLE ALIMENTACION HOJAS','40X0959',1,'2019-11-14',3,2,'1 - ALMACÉN ',NULL),(80,'PICKUP  ROLLER TIRE KIT','41X0958',2,'2018-09-27',3,2,'2 - ALMACÉN ',NULL),(81,'SENSOR BUMP EXIT APERTURE','41X2278',1,'2018-04-07',3,15,'1 - ALMACÉN\r\n ',NULL),(82,'COVER FRONT ACCESS MPF ','40X9068',1,'2020-01-07',3,2,'Y LE QUEDA A MS611',NULL),(83,'ADF ASSEMBLY','40X9093',1,'2020-01-07',3,2,'1 - ALMACEN ',NULL),(84,'IMPRESORA','7463369904DB8',1,'2020-01-07',3,1,'1 - ALMACEN ',NULL),(85,'IMPRESORA','7463479905W2C',1,'2020-01-07',3,1,'1 - ALMACEN',NULL),(86,'IMPRESORA','701644HH33K7',1,'2020-01-07',3,2,'1 - ALMACEN ',NULL),(87,'IMPRESORA','451944HH18T35',1,'2020-01-07',3,14,'1 - ALMACEN ',NULL),(88,'IMPRESORA','451432LMOXH9M',1,'2020-01-07',3,17,'1 - OFICINA',NULL),(89,'IMPRESORA','701644HHO34MY',1,'2020-01-07',3,18,'1 - OFICINA',NULL),(92,'Control panel Completa','40X9246',0,'2020-02-07',3,1,'','45 X 16 X 28'),(93,'KIT Mantto. ADF','40X8431',0,'2020-02-07',3,1,'','30 X 14 X 23'),(94,'Bandeja 1 ','40x0976',0,'2020-02-07',3,1,'','60 x 18 x 57'),(95,'Kit Mantto.','40X8420',0,'2020-02-07',3,1,'','39 X 26 X 29'),(96,'Selenoide del MPF','40X7712',0,'2020-02-07',3,1,'','11 X 5 X 10'),(97,'MOTOR TONER Add','40x7596',0,'2020-02-07',3,1,'','22 x 10 x 15'),(98,'PRINT HEAD','40X8079',0,'2020-02-07',3,2,'','40 X 8 X 30'),(99,'ADF ASSEMBLY','40X9023',0,'2020-02-07',3,2,'','56 X 20 X 46'),(100,'MOTOR TONER','40X8083',0,'2020-02-07',3,2,'','23 X 10 X 15'),(101,'Kit Mantto.','40X9135',0,'2020-02-07',3,19,'','50 X 24 X 33'),(102,'REDRIVER','40X8438',0,'2020-02-07',3,16,'','37 X 12 X 22'),(103,'PICK ROLLER TIRE','41X0918',0,'2020-02-07',3,10,'','11 X 13 X  6');
/*!40000 ALTER TABLE `t_Refaccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Rol`
--

DROP TABLE IF EXISTS `t_Rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Rol` (
  `id_rol` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `rol` varchar(80) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Rol`
--

LOCK TABLES `t_Rol` WRITE;
/*!40000 ALTER TABLE `t_Rol` DISABLE KEYS */;
INSERT INTO `t_Rol` VALUES (1,'Administrador'),(2,'Supervisor'),(3,'ingenieria');
/*!40000 ALTER TABLE `t_Rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Sucursales`
--

DROP TABLE IF EXISTS `t_Sucursales`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Sucursales` (
  `id_sucursal` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(80) NOT NULL,
  `num_suc` varchar(45) NOT NULL,
  `domicilio` varchar(90) NOT NULL,
  `referencias` text DEFAULT NULL,
  `tel_fijo` varchar(15) DEFAULT NULL,
  `tel_movil` varchar(45) DEFAULT NULL,
  `contacto` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`id_sucursal`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Sucursales`
--

LOCK TABLES `t_Sucursales` WRITE;
/*!40000 ALTER TABLE `t_Sucursales` DISABLE KEYS */;
INSERT INTO `t_Sucursales` VALUES (1,'Banamex Matamoros','4333','Ruta Independencia No. 15150','Dentro Plaza Mariano Matamoros','664-999-99-99','664-99-99','Julio Salazar'),(3,'Banamex La Mesa','0390','Blvd. Agua Caliente No. 140','Enfrente de Telcel 5y10  nma sdansd nma sdnmads amnsd ands amnsd amns danm dsamsnd adsman dsans dman damsnd amsnd man dsman dsman d','664-999-99-99','664-99-99','Margarita Solis'),(5,'NOMBRE SUCURSAL 2-editado','NUMERO SUCURSAL 2-editado','DOMICILIO SUCURSAL 2-editado','REFERENCIAS 2-editado','TEL FIJO 2-edit','TELEFONO CELULAR 2-editado','CONTACTO 2-editado'),(6,'NOMBRE SUCURSAL 2','NUMERO SUCURSAL 2','DOMICILIO SUCURSAL 2','REFERENCIAS 2','TEL FIJO 2','TELEFONO CELULAR 2','CONTACTO 2'),(7,'NOMBRE SUCURSAL 2','NUMERO SUCURSAL 2','DOMICILIO SUCURSAL 2','REFERENCIAS 2','TEL FIJO 2','TELEFONO CELULAR 2','CONTACTO 2'),(8,'NOMBRE SUCURSAL 3','NUMERO SUCURSAL 3','DOMICILIO 3','REFERENCIA 3','TELEFONO 3','CELULAR 3','CONTACTO 3'),(9,'NOMBRE SUCURSAL 1','NUMERO SUCURSAL 1','DOMICILIO SUCURSAL 1','REFERENCIA SUCURSAL 1','TELEFONO SUC 1','CELULAR SUC 1','CONTACTO SUC1');
/*!40000 ALTER TABLE `t_Sucursales` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Tipo_Componente`
--

DROP TABLE IF EXISTS `t_Tipo_Componente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Tipo_Componente` (
  `id_tipo_componente` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_componente`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Tipo_Componente`
--

LOCK TABLES `t_Tipo_Componente` WRITE;
/*!40000 ALTER TABLE `t_Tipo_Componente` DISABLE KEYS */;
INSERT INTO `t_Tipo_Componente` VALUES (1,'Escritorio'),(2,'Escritorio Moderno'),(3,'Portatil'),(4,'Teclado'),(5,'NoteBook');
/*!40000 ALTER TABLE `t_Tipo_Componente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_Usuarios`
--

DROP TABLE IF EXISTS `t_Usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `t_Usuarios` (
  `idusuario` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `usuario` varchar(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `cumpleanos` date NOT NULL,
  `clave` char(32) NOT NULL,
  `perfil` enum('Admin','User') NOT NULL,
  `estatus` char(1) NOT NULL DEFAULT '1',
  `id_rol` int(10) unsigned NOT NULL,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `email` (`email`),
  KEY `id_rol` (`id_rol`),
  CONSTRAINT `t_Usuarios_ibfk_1` FOREIGN KEY (`id_rol`) REFERENCES `t_Rol` (`id_rol`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Usuarios`
--

LOCK TABLES `t_Usuarios` WRITE;
/*!40000 ALTER TABLE `t_Usuarios` DISABLE KEYS */;
INSERT INTO `t_Usuarios` VALUES (1,'@admin','admin@gmail.com','Administrador','1980-10-10','81dc9bdb52d04dc20036dbd8313ed055','Admin','1',1),(2,'@usuario','usuario@gmail.com','Usuario','1990-11-11','d93591bdf7860e1e4ee2fca799911215','User','1',2);
/*!40000 ALTER TABLE `t_Usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-08  3:02:16
