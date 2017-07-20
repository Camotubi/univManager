-- MySQL dump 10.16  Distrib 10.1.21-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: localhost
-- ------------------------------------------------------
-- Server version	10.1.21-MariaDB

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
-- Table structure for table `Asignatura`
--

DROP TABLE IF EXISTS `Asignatura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Asignatura` (
  `cod_asig` varchar(10) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `creditos` int(11) DEFAULT NULL,
  `duracion_bruta` int(11) DEFAULT NULL,
  PRIMARY KEY (`cod_asig`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Asignatura`
--

LOCK TABLES `Asignatura` WRITE;
/*!40000 ALTER TABLE `Asignatura` DISABLE KEYS */;
INSERT INTO `Asignatura` VALUES ('BD-1','Base de Datos',4,25),('met-1','Metodos Numericos',4,64),('OAC','Organizacion y arquitectura de',4,64);
/*!40000 ALTER TABLE `Asignatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Estudiante`
--

DROP TABLE IF EXISTS `Estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Estudiante` (
  `id_estudiante` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id_estudiante`),
  KEY `FK_PersonaEstudiante` (`cedula`),
  CONSTRAINT `FK_PersonaEstudiante` FOREIGN KEY (`cedula`) REFERENCES `Persona` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Estudiante`
--

LOCK TABLES `Estudiante` WRITE;
/*!40000 ALTER TABLE `Estudiante` DISABLE KEYS */;
INSERT INTO `Estudiante` VALUES (3,'2-222-222'),(4,'3-333-333');
/*!40000 ALTER TABLE `Estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Persona`
--

DROP TABLE IF EXISTS `Persona`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Persona` (
  `cedula` varchar(20) CHARACTER SET latin1 NOT NULL,
  `nombre` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `apellido` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `direccion` varchar(200) CHARACTER SET latin1 DEFAULT NULL,
  `sexo` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `correo` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`cedula`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Persona`
--

LOCK TABLES `Persona` WRITE;
/*!40000 ALTER TABLE `Persona` DISABLE KEYS */;
INSERT INTO `Persona` VALUES ('0-000-000','Juanito','Perez',NULL,NULL,NULL,NULL),('1-111-111','Camo','Tubi',NULL,NULL,NULL,NULL),('1-234-567','Mario','Muñoz','34534534','USA','M','dsff@usa.com'),('2-222-222','Miguel','Cheung','1234567','La floresta','M','123@123.com'),('3-333-333','Jose','Aguirre','1234567','Amador','M','456@123.com'),('4-444-444','Melinda','Villalaz','98765431','Via España','F','sdfg@1sdf.com'),('5-555-555','Johana','Velasquez','98765431','Calle 50','F','sdfdfgdfgdfg@1sdf.com'),('6-666-666','Victor','SASSO','234654','Condado del Rey','M','utp@utp.com'),('7-777-777','Marcos','Alfaro','345364','Penonome','M','salino@miweb.com'),('8-888-888','Mirta','Perez','3453453','Emiratos','F','wao@emiratos.com'),('9-999-999','Larry','Rodriguez','54756856','Colombia','M','3453@achemail.com'),('Johana','Velasquez','5-555-555','98765431','Calle 50','F','sdfdfgdfgdfg@1sdf.com'),('Jose','Aguirre','3-333-333','1234567','Amador','M','456@123.com'),('Larry','Rodriguez','9-999-999','54756856','Colombia','M','3453@achemail.com'),('Marcos','Alfaro','7-777-777','345364','Penonome','M','salino@miweb.com'),('Mario','Muñoz','1-234-567','34534534','USA','M','dsff@usa.com'),('Melinda','Villalaz','4-444-444','98765431','Via España','F','sdfg@1sdf.com'),('Miguel','Cheung','2-222-222','1234567','La floresta','M','123@123.com'),('Mirta','Perez','8-888-888','3453453','Emiratos','F','wao@emiratos.com'),('Victor','SASSO','6-666-666','234654','Condado del Rey','M','utp@utp.com');
/*!40000 ALTER TABLE `Persona` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Profesor`
--

DROP TABLE IF EXISTS `Profesor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Profesor` (
  `id_profesor` int(11) NOT NULL AUTO_INCREMENT,
  `cedula` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id_profesor`),
  KEY `FK_PersonaProfesor` (`cedula`),
  CONSTRAINT `FK_PersonaProfesor` FOREIGN KEY (`cedula`) REFERENCES `Persona` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Profesor`
--

LOCK TABLES `Profesor` WRITE;
/*!40000 ALTER TABLE `Profesor` DISABLE KEYS */;
INSERT INTO `Profesor` VALUES (1,'1-234-567');
/*!40000 ALTER TABLE `Profesor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Programa`
--

DROP TABLE IF EXISTS `Programa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Programa` (
  `cod_plan` varchar(10) NOT NULL,
  `descripccion` varchar(1000) DEFAULT NULL,
  `nombre` varchar(50) DEFAULT NULL,
  `fecha_apro` date DEFAULT NULL,
  PRIMARY KEY (`cod_plan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Programa`
--

LOCK TABLES `Programa` WRITE;
/*!40000 ALTER TABLE `Programa` DISABLE KEYS */;
INSERT INTO `Programa` VALUES ('1','El diseño del plan de estudios considera la formación basada en competencias, integrando disciplinas','Ingenieria de Software','2014-00-00'),('2','La Licenciatura en Desarrollo de Software busca suplir las necesidades de las organizaciones o empre','Desarrollo de Software','2010-00-00'),('3','La Carrera de Licenciatura en Redes Informáticas forma excelentes profesionales, líderes en el campo','Redes Informaticas','2005-00-00'),('ALI-1','descripcciomn','Alimentos','2017-06-29');
/*!40000 ALTER TABLE `Programa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ProgramaAsignatura`
--

DROP TABLE IF EXISTS `ProgramaAsignatura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ProgramaAsignatura` (
  `cod_asig` varchar(10) CHARACTER SET latin1 NOT NULL,
  `cod_plan` varchar(10) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`cod_asig`,`cod_plan`),
  KEY `FK_ProgramaAsignatura_Programa` (`cod_plan`),
  CONSTRAINT `FK_ProgramaAsignatura_Asignatura` FOREIGN KEY (`cod_asig`) REFERENCES `Asignatura` (`cod_asig`),
  CONSTRAINT `FK_ProgramaAsignatura_Programa` FOREIGN KEY (`cod_plan`) REFERENCES `Programa` (`cod_plan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ProgramaAsignatura`
--

LOCK TABLES `ProgramaAsignatura` WRITE;
/*!40000 ALTER TABLE `ProgramaAsignatura` DISABLE KEYS */;
INSERT INTO `ProgramaAsignatura` VALUES ('OAC','1');
/*!40000 ALTER TABLE `ProgramaAsignatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Usuario`
--

DROP TABLE IF EXISTS `Usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Usuario` (
  `id_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `contra` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `cedula` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `UNIQUE_UsuarioUsername` (`username`),
  KEY `FK_PersonaUsuario` (`cedula`),
  CONSTRAINT `FK_PersonaUsuario` FOREIGN KEY (`cedula`) REFERENCES `Persona` (`cedula`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Usuario`
--

LOCK TABLES `Usuario` WRITE;
/*!40000 ALTER TABLE `Usuario` DISABLE KEYS */;
INSERT INTO `Usuario` VALUES (1,'master','1234','1-111-111');
/*!40000 ALTER TABLE `Usuario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-07-20  4:32:43
