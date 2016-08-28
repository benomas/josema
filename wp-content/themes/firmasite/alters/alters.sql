-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: josemaco_wp_store
-- ------------------------------------------------------
-- Server version	5.6.16

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
-- Table structure for table `ci_resumen_inventario`
--

USE `josemaco_wp_store`;
DROP TABLE IF EXISTS `ci_resumen_inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_resumen_inventario` (
  `id_resumen_inventario` int(11) NOT NULL AUTO_INCREMENT,
  `busqueda` varchar(2000) DEFAULT NULL,
  `id_inventario` int(11) DEFAULT NULL,
  `npc` varchar(45) DEFAULT NULL,
  `componente` varchar(255) DEFAULT NULL,
  `marca` varchar(255) DEFAULT NULL,
  `marca_componente` varchar(255) DEFAULT NULL,
  `marca_refaccion` varchar(255) DEFAULT NULL,
  `descripcion` varchar(2000) DEFAULT NULL,
  `origen` varchar(45) DEFAULT NULL,
  `precio_base` varchar(45) DEFAULT NULL,
  `referencias` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`id_resumen_inventario`),
  UNIQUE KEY `id_resumen_inventario` (`id_resumen_inventario`),
  UNIQUE KEY `id_inventario` (`id_inventario`),
  KEY `busqueda` (`busqueda`(767)),
  KEY `npc` (`npc`),
  KEY `componente` (`componente`),
  KEY `marca` (`marca`),
  KEY `marca_componente` (`marca_componente`),
  KEY `marca_refaccion` (`marca_refaccion`),
  KEY `descripcion` (`descripcion`(767)),
  KEY `origen` (`origen`),
  KEY `referencias` (`referencias`(767))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_resumen_inventario`
--

LOCK TABLES `ci_resumen_inventario` WRITE;
/*!40000 ALTER TABLE `ci_resumen_inventario` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_resumen_inventario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'josemaco_wp_store'
--

--
-- Dumping routines for database 'josemaco_wp_store'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-07-17 16:10:51


USE `josemaco_wp_store`;
DROP procedure IF EXISTS `make_ci_resumen_inventario`;

DELIMITER $$
USE `josemaco_wp_store`$$
CREATE DEFINER=CURRENT_USER PROCEDURE `make_ci_resumen_inventario`()
BEGIN
  TRUNCATE TABLE ci_resumen_inventario;

    INSERT INTO ci_resumen_inventario
(busqueda,id_inventario,npc,componente,marca,marca_componente,marca_refaccion,descripcion,origen,precio_base,referencias)
(SELECT
  CONCAT(IFNULL(tc.nombre, ' '),
            ' ',
            IFNULL(m.nombre, ' '),
            ' ',
            IFNULL(mc.nombre, ' '),
            ' ',
            IFNULL(mr.nombre, ' '),
            ' ',
            IFNULL(i.descripcion, ' '),
            ' ',
            IFNULL(o.nombre, ' '),
            ' ',
            IFNULL(i.npc, ' '),
            ' ',
            IFNULL((SELECT
                            GROUP_CONCAT(ir.codigo
                                    SEPARATOR ', ')
                        FROM
                            ci_inventario_referencia AS ir
                        WHERE
                            ir.id_inventario = i.id_inventario),
                    ' ')) AS busqueda,
    i.id_inventario,
    i.npc,
    tc.nombre AS componente,
    m.nombre AS marca,
    mc.nombre AS marca_componente,
    mr.nombre AS marca_refaccion,
    i.descripcion,
    o.nombre AS origen,
    ipv.monto AS precio_base,
    (SELECT
            GROUP_CONCAT(ir.codigo
                    SEPARATOR ', ')
        FROM
            ci_inventario_referencia AS ir
        WHERE
            ir.id_inventario = i.id_inventario) AS referencias
FROM
    ci_inventario AS i
        LEFT JOIN
    ci_tipo_componente AS tc ON tc.id_tipo_componente = i.id_tipo_componente
        LEFT JOIN
    ci_marca AS m ON m.id_marca = i.id_marca
        LEFT JOIN
    ci_marcacomponente AS mc ON mc.id_marcacomponente = i.id_marcacomponente
        LEFT JOIN
    ci_marcarefaccion AS mr ON mr.id_marcarefaccion = i.id_marcarefaccion
        LEFT JOIN
    ci_origen AS o ON o.id_origen = i.id_origen
        LEFT JOIN
    ci_inventario_precio_venta AS ipv ON ipv.id_inventario = i.id_inventario);
END$$

DELIMITER ;

CALL make_ci_resumen_inventario;
-- checkPoint:{User:Benomas,From:homePc}
-- checkPoint:{User:Benomas,From:Producction}
USE `josemaco_wp_store`;
DROP TABLE IF EXISTS `ci_resumen_inventario`;

CREATE TABLE `ci_resumen_inventario` (
  `id_resumen_inventario` INT NOT NULL AUTO_INCREMENT,
  `npc` VARCHAR(45) NULL,
  `numero` VARCHAR(255) NULL,
  `presentacion` VARCHAR(255) NULL,
  `tipo` VARCHAR(255) NULL,
  `sub_tipo` VARCHAR(255) NULL,
  `embalaje` VARCHAR(255) NULL,
  `marca_componente` VARCHAR(255) NULL,
  `componente` VARCHAR(255) NULL,
  `marca` VARCHAR(255) NULL,
  `marca_refaccion` VARCHAR(255) NULL,
  `proveedor` VARCHAR(255) NULL,
  `descripcion` VARCHAR(2000) NULL,
  `precio_lista` VARCHAR(45) NULL,
  `precio_compra` VARCHAR(45) NULL,
  `a` VARCHAR(45) NULL,
  `b` VARCHAR(45) NULL,
  `c` VARCHAR(45) NULL,
  `d` VARCHAR(45) NULL,
  `e` VARCHAR(45) NULL,
  `f` VARCHAR(45) NULL,
  `g` VARCHAR(45) NULL,
  `precio_promocion1` VARCHAR(45) NULL,
  `precio_promocion2` VARCHAR(45) NULL,
  `condicion_compra` VARCHAR(255) NULL,
  `codigo` VARCHAR(45) NULL,
  `original` VARCHAR(45) NULL,
  `airtex` VARCHAR(45) NULL,
  `carter` VARCHAR(45) NULL,
  `kem` VARCHAR(45) NULL,
  `walbro` VARCHAR(45) NULL,
  `pfp` VARCHAR(45) NULL,
  `delphi` VARCHAR(45) NULL,
  `std` VARCHAR(45) NULL,
  `wells` VARCHAR(45) NULL,
  `tomco` VARCHAR(45) NULL,
  `transpo` VARCHAR(45) NULL,
  `wai` VARCHAR(45) NULL,
  `bosch` VARCHAR(45) NULL,
  `unipoint` VARCHAR(45) NULL,
  `interfil` VARCHAR(45) NULL,
  `oe_otro` VARCHAR(45) NULL,
  `referencias` VARCHAR(2000) NULL,
  `busqueda` VARCHAR(2000) NULL,
  PRIMARY KEY (`id_resumen_inventario`));


-- checkPoint:{User:Benomas,From:homePc}
