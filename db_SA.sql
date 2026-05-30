CREATE DATABASE  IF NOT EXISTS `strategi_algo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `strategi_algo`;
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: localhost    Database: strategi_algo
-- ------------------------------------------------------
-- Server version	8.0.44

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
-- Table structure for table `detail_jadwal`
--

DROP TABLE IF EXISTS `detail_jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_jadwal` (
  `id_detail_jadwal` int NOT NULL AUTO_INCREMENT,
  `id_jadwal` int DEFAULT NULL,
  `id_karyawan` int DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  `shift_kerja` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id_detail_jadwal`),
  KEY `id_jadwal` (`id_jadwal`),
  KEY `id_karyawan` (`id_karyawan`),
  CONSTRAINT `detail_jadwal_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`),
  CONSTRAINT `detail_jadwal_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_jadwal`
--

LOCK TABLES `detail_jadwal` WRITE;
/*!40000 ALTER TABLE `detail_jadwal` DISABLE KEYS */;
INSERT INTO `detail_jadwal` VALUES (4,2,1,'2026-06-08','Malam'),(5,2,4,'2026-06-08','Pagi'),(6,2,5,'2026-06-08','Siang'),(7,3,2,'2026-06-17','Libur'),(8,3,3,'2026-06-17','Libur'),(9,3,4,'2026-06-17','Libur'),(31,2,5,'2026-06-08','Pagi'),(32,2,5,'2026-06-09','Siang'),(33,2,5,'2026-06-10','Malam'),(34,2,5,'2026-06-11','Pagi'),(35,2,5,'2026-06-12','Siang'),(36,2,5,'2026-06-13','Malam'),(37,2,5,'2026-06-14','Libur'),(38,3,5,'2026-06-15','Pagi'),(39,3,5,'2026-06-16','Siang'),(40,3,5,'2026-06-17','Libur'),(41,3,5,'2026-06-18','Pagi'),(42,3,5,'2026-06-19','Siang'),(43,3,5,'2026-06-20','Malam'),(44,3,5,'2026-06-21','Libur');
/*!40000 ALTER TABLE `detail_jadwal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jadwal`
--

DROP TABLE IF EXISTS `jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jadwal` (
  `id_jadwal` int NOT NULL AUTO_INCREMENT,
  `id_pembuat` int DEFAULT NULL,
  `nama_jadwal` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_jadwal`),
  KEY `id_pembuat` (`id_pembuat`),
  CONSTRAINT `jadwal_ibfk_1` FOREIGN KEY (`id_pembuat`) REFERENCES `pembuat_jadwal` (`id_pembuat`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal`
--

LOCK TABLES `jadwal` WRITE;
/*!40000 ALTER TABLE `jadwal` DISABLE KEYS */;
INSERT INTO `jadwal` VALUES (2,2,'Jadwal Shift Minggu Kedua'),(3,3,'Jadwal Shift Libur Nasional');
/*!40000 ALTER TABLE `jadwal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `karyawan`
--

DROP TABLE IF EXISTS `karyawan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `karyawan` (
  `id_karyawan` int NOT NULL AUTO_INCREMENT,
  `kode_unik` varchar(255) DEFAULT NULL,
  `nama_karyawan` varchar(255) DEFAULT NULL,
  `kelamin` enum('L','P') DEFAULT NULL,
  PRIMARY KEY (`id_karyawan`),
  UNIQUE KEY `kode_unik` (`kode_unik`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karyawan`
--

LOCK TABLES `karyawan` WRITE;
/*!40000 ALTER TABLE `karyawan` DISABLE KEYS */;
INSERT INTO `karyawan` VALUES (1,'KR001','Andi Saputra',NULL),(2,'KR002','Budi Santoso',NULL),(3,'KR003','Citra Dewi',NULL),(4,'KR004','Dewi Lestari',NULL),(5,'KR005','Eko Prasetyo',NULL),(8,'KU008','hello','P'),(9,'KU009','hello','P'),(10,'KU010','yanto','L');
/*!40000 ALTER TABLE `karyawan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembuat_dan_karyawan`
--

DROP TABLE IF EXISTS `pembuat_dan_karyawan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembuat_dan_karyawan` (
  `id_pdk` int NOT NULL AUTO_INCREMENT,
  `id_pembuat` int DEFAULT NULL,
  `id_karyawan` int DEFAULT NULL,
  PRIMARY KEY (`id_pdk`),
  KEY `id_pembuat` (`id_pembuat`),
  KEY `id_karyawan` (`id_karyawan`),
  CONSTRAINT `pembuat_dan_karyawan_ibfk_1` FOREIGN KEY (`id_pembuat`) REFERENCES `pembuat_jadwal` (`id_pembuat`),
  CONSTRAINT `pembuat_dan_karyawan_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembuat_dan_karyawan`
--

LOCK TABLES `pembuat_dan_karyawan` WRITE;
/*!40000 ALTER TABLE `pembuat_dan_karyawan` DISABLE KEYS */;
INSERT INTO `pembuat_dan_karyawan` VALUES (1,1,1),(2,1,2),(3,1,3),(4,2,4),(5,3,5),(8,5,8),(9,5,9),(10,5,10);
/*!40000 ALTER TABLE `pembuat_dan_karyawan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pembuat_jadwal`
--

DROP TABLE IF EXISTS `pembuat_jadwal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pembuat_jadwal` (
  `id_pembuat` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id_pembuat`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembuat_jadwal`
--

LOCK TABLES `pembuat_jadwal` WRITE;
/*!40000 ALTER TABLE `pembuat_jadwal` DISABLE KEYS */;
INSERT INTO `pembuat_jadwal` VALUES (1,'admin1','admin123'),(2,'admin2','password456'),(3,'supervisor','super789'),(4,'','$2y$12$McUjsqio9fajX74IDbgOsODoZHk.iY6X9BYf5d5/uCrLm8nWMctby'),(5,'admin','$2y$12$J3gfBy74/oMq0g/JE8CPAeqKZevzQ7l8necbAQ8FpVjeHIr5IN6iu');
/*!40000 ALTER TABLE `pembuat_jadwal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'strategi_algo'
--

--
-- Dumping routines for database 'strategi_algo'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-05-30 16:30:41
