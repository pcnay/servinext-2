-- MySQL dump 10.17  Distrib 10.3.15-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ordenservicios
-- ------------------------------------------------------
-- Server version	10.3.15-MariaDB-1:10.3.15+maria~stretch

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
  KEY `id_tipo_componente` (`id_tipo_componente`),
  KEY `id_marca` (`id_marca`),
  KEY `id_modelo` (`id_modelo`),
  CONSTRAINT `t_Equipo_ibfk_1` FOREIGN KEY (`id_tipo_componente`) REFERENCES `t_Tipo_Componente` (`id_tipo_componente`) ON UPDATE CASCADE,
  CONSTRAINT `t_Equipo_ibfk_2` FOREIGN KEY (`id_marca`) REFERENCES `t_Marca` (`id_marca`) ON UPDATE CASCADE,
  CONSTRAINT `t_Equipo_ibfk_3` FOREIGN KEY (`id_modelo`) REFERENCES `t_Modelo` (`id_modelo`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Equipo`
--

LOCK TABLES `t_Equipo` WRITE;
/*!40000 ALTER TABLE `t_Equipo` DISABLE KEYS */;
INSERT INTO `t_Equipo` VALUES (1,'7410HH348984','Numero De Inventario 1','40X4598',1,1,1,1,NULL),(2,'7410HH348993','Numero De Inventario 2','NUMPARTE10',2,2,1,1,NULL),(3,'9410HH348081','Numero De Inventario 3','NUMPARTE20',4,1,1,1,NULL);
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Marca`
--

LOCK TABLES `t_Marca` WRITE;
/*!40000 ALTER TABLE `t_Marca` DISABLE KEYS */;
INSERT INTO `t_Marca` VALUES (1,'HewllwtPackard'),(2,'Dell'),(3,'Lexmark');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Modelo`
--

LOCK TABLES `t_Modelo` WRITE;
/*!40000 ALTER TABLE `t_Modelo` DISABLE KEYS */;
INSERT INTO `t_Modelo` VALUES (1,'MX711'),(2,'MX611'),(3,'Optiplex 970'),(4,'MS510');
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
  PRIMARY KEY (`id_refaccion`),
  UNIQUE KEY `num_parte` (`num_parte`),
  KEY `id_marca` (`id_marca`),
  KEY `id_modelo` (`id_modelo`),
  CONSTRAINT `t_Refaccion_ibfk_1` FOREIGN KEY (`id_marca`) REFERENCES `t_Marca` (`id_marca`) ON UPDATE CASCADE,
  CONSTRAINT `t_Refaccion_ibfk_2` FOREIGN KEY (`id_modelo`) REFERENCES `t_Modelo` (`id_modelo`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Refaccion`
--

LOCK TABLES `t_Refaccion` WRITE;
/*!40000 ALTER TABLE `t_Refaccion` DISABLE KEYS */;
INSERT INTO `t_Refaccion` VALUES (8,'MPF FEEDER  LIFT PLATE WITH CABLE','40X7598',1,'2019-12-27',3,1,'OFICINA'),(10,'ENSAMBLE ALIMENTACION PAPEL','41X0959',1,'2019-12-27',3,2,'OFICINA'),(11,'JAM ACCESS COVER','40X8279',1,'2019-12-27',3,2,'OFICINA'),(12,'PANEL BOARD CONTROL','40X9245',1,'2019-12-27',3,1,'OFICINA'),(13,'MEDIA FEEDER ','40X7591',1,'2019-12-27',3,1,'OFICINA'),(14,'MEDIA ALIGNER ROLLER WIHT MPF PICK ROLL ','40X7599',2,'2019-12-27',3,1,'OFICINA'),(15,'UPPER REDRIVER ','40X7602',2,'2019-12-27',3,1,'OFICINA'),(17,'PRINT HEAD','40X7597',1,'2019-12-27',3,1,'OFICINA'),(18,'ROLL TRANSFER ','40X8393',1,'2019-12-27',3,2,'OFICINA'),(20,'BIZEL DERECHO BASE TECLADO NUMERICO','40X7865',1,'2019-12-27',3,1,'OFICINA'),(21,'BOTONES DE TECLADO','40X7863',1,'2019-12-27',3,1,'OFICINA'),(22,'HVPS','40X7578',1,'2019-12-27',3,1,'OFICINA'),(23,'MPF GEAR BOX COMPLETO','40X8777',2,'2019-12-27',3,2,'OFICINA'),(24,'FRONT IMPUT GUIDE','40X8280',1,'2019-12-27',3,2,'OFICINA'),(25,'MEDIA TURN','40X7583',1,'2019-12-27',3,1,'OFICINA'),(26,'SENSOR STD BIR FULL WITH OUTPUT BIR GUIDE','40X7691',1,'2019-12-27',3,1,'OFICINA'),(27,'REDIVER ANSSAMBLED','40X8298',1,'2019-12-27',3,4,'OFICINA'),(31,'MPF PICKUP ROLLER AND SEPARATOR PAD','40X8295',6,'2019-12-27',3,2,'OFICINA'),(32,'MPF PICK ROLLER','40S7600',4,'2019-12-27',3,1,'OFICINA'),(33,'MPF PICK ROLLER  ASSEMBLY','40X7593',2,'2019-12-27',3,1,'OFICINA'),(34,'CONTRACT CARTRIDGE SMART CHIP','40X8266',2,'2019-12-27',3,2,'OFICINA'),(35,'CABLE CONTROL PANEL','40X9052',1,'2019-12-27',3,1,'OFICINA\r\nLES QUEDAN A ESTOS MODELOS\r\n40 x 9052 Lexmark Cable uicc MX410de MX511de MX511dte MX610de MX310dn MX511dte'),(36,'HVPS CONTACT','41X1721',1,'2019-12-27',3,1,'OFICINA'),(37,'SENSOR NARROW MEDIA BIN FULL','40X8050',1,'2019-12-27',3,1,'OFICINA'),(38,'MEDIA PRESENT SENSOR FLAG','40X8800',1,'2019-12-27',3,2,'OFICINA'),(39,'ADF SEPARATOR ROLLER','40X7775',1,'2019-12-27',3,1,'OFICINA'),(40,'DUPLEX GEAR ASSAMBLY','40X8277',1,'2019-12-27',3,2,'OFICINA'),(41,'CONTROL PANEL INTERLOCK SENSOR','40X7693',1,'2019-12-27',3,1,'OFICINA'),(42,'MEDIA SENSOR','41X0259',1,'2019-12-27',3,2,'OFICNA \r\nTAMBIEN LE QUEDA A LAS\r\nMX410, 511 MX610 \r\nDE NUMERO DE PARTE 41X0259'),(43,'PKK ROLLER OPTION TRAY','40X8443',5,'2019-12-27',3,2,'OFICINA'),(44,'TRANSFER ROLL','40X7582',2,'2019-12-27',3,1,'OFICINA'),(45,'HCIT SEPARATOR ROLLER','40X7713',3,'2019-12-27',3,1,'OFICINA'),(47,'SEPARATOR ROLL ASSAMBLY','40X8444',1,'2019-12-27',3,2,'OFICINA');
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_Sucursales`
--

LOCK TABLES `t_Sucursales` WRITE;
/*!40000 ALTER TABLE `t_Sucursales` DISABLE KEYS */;
INSERT INTO `t_Sucursales` VALUES (1,'Banamex Matamoros','4333','Ruta Independencia No. 15150','Dentro Plaza Mariano Matamoros','664-999-99-99','664-99-99','Julio Salazar'),(2,'Compartamos Banco','Los Pinos','Blvd. Diaz Ordaz No. 10430','Aun lado de la CFE','664-999-99-99','664-99-99','Juana Sanchez'),(3,'Banamex La Mesa','0390','Blvd. Agua Caliente No. 140','Enfrente de Telcel 5y10 ','664-999-99-99','664-99-99','Margarita Solis');
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

-- Dump completed on 2019-12-27 22:33:20
