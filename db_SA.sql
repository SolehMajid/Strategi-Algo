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
  UNIQUE KEY `karyawan_dan_tanggal_unik` (`id_karyawan`,`tanggal`),
  KEY `id_jadwal` (`id_jadwal`),
  KEY `idx_karyawan` (`id_karyawan`),
  CONSTRAINT `detail_jadwal_ibfk_1` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal` (`id_jadwal`),
  CONSTRAINT `detail_jadwal_ibfk_2` FOREIGN KEY (`id_karyawan`) REFERENCES `karyawan` (`id_karyawan`)
) ENGINE=InnoDB AUTO_INCREMENT=108 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_jadwal`
--

LOCK TABLES `detail_jadwal` WRITE;
/*!40000 ALTER TABLE `detail_jadwal` DISABLE KEYS */;
INSERT INTO `detail_jadwal` VALUES (4,2,1,'2026-06-08','Malam'),(5,2,4,'2026-06-08','Pagi'),(7,3,2,'2026-06-17','Libur'),(8,3,3,'2026-06-17','Libur'),(9,3,4,'2026-06-17','Libur'),(31,2,5,'2026-06-08','Pagi'),(32,2,5,'2026-06-09','Siang'),(33,2,5,'2026-06-10','Malam'),(34,2,5,'2026-06-11','Pagi'),(35,2,5,'2026-06-12','Siang'),(36,2,5,'2026-06-13','Malam'),(37,2,5,'2026-06-14','Libur'),(38,3,5,'2026-06-15','Pagi'),(39,3,5,'2026-06-16','Siang'),(40,3,5,'2026-06-17','Libur'),(41,3,5,'2026-06-18','Pagi'),(42,3,5,'2026-06-19','Siang'),(43,3,5,'2026-06-20','Malam'),(44,3,5,'2026-06-21','Libur'),(45,4,8,'2026-06-28','Pagi'),(46,4,9,'2026-06-28','Pagi'),(47,4,10,'2026-06-28','Pagi'),(48,4,13,'2026-06-28','Siang'),(49,4,14,'2026-06-28','Siang'),(50,4,15,'2026-06-28','Siang'),(51,4,16,'2026-06-28','Libur'),(52,4,17,'2026-06-28','Libur'),(53,4,18,'2026-06-28','Libur'),(54,4,8,'2026-06-29','Siang'),(55,4,9,'2026-06-29','Siang'),(56,4,10,'2026-06-29','Siang'),(57,4,13,'2026-06-29','Libur'),(58,4,14,'2026-06-29','Libur'),(59,4,15,'2026-06-29','Libur'),(60,4,16,'2026-06-29','Pagi'),(61,4,17,'2026-06-29','Pagi'),(62,4,18,'2026-06-29','Pagi'),(63,4,8,'2026-06-30','Libur'),(64,4,9,'2026-06-30','Libur'),(65,4,10,'2026-06-30','Libur'),(66,4,13,'2026-06-30','Siang'),(67,4,14,'2026-06-30','Siang'),(68,4,15,'2026-06-30','Siang'),(69,4,16,'2026-06-30','Pagi'),(70,4,17,'2026-06-30','Pagi'),(71,4,18,'2026-06-30','Pagi'),(72,4,8,'2026-07-01','Libur'),(73,4,9,'2026-07-01','Libur'),(74,4,10,'2026-07-01','Libur'),(75,4,13,'2026-07-01','Siang'),(76,4,14,'2026-07-01','Siang'),(77,4,15,'2026-07-01','Siang'),(78,4,16,'2026-07-01','Pagi'),(79,4,17,'2026-07-01','Pagi'),(80,4,18,'2026-07-01','Pagi'),(81,4,8,'2026-07-02','Pagi'),(82,4,9,'2026-07-02','Pagi'),(83,4,10,'2026-07-02','Pagi'),(84,4,13,'2026-07-02','Libur'),(85,4,14,'2026-07-02','Libur'),(86,4,15,'2026-07-02','Libur'),(87,4,16,'2026-07-02','Siang'),(88,4,17,'2026-07-02','Siang'),(89,4,18,'2026-07-02','Siang'),(90,4,8,'2026-07-03','Pagi'),(91,4,9,'2026-07-03','Pagi'),(92,4,10,'2026-07-03','Pagi'),(93,4,13,'2026-07-03','Siang'),(94,4,14,'2026-07-03','Siang'),(95,4,15,'2026-07-03','Siang'),(96,4,16,'2026-07-03','Libur'),(97,4,17,'2026-07-03','Libur'),(98,4,18,'2026-07-03','Libur'),(99,4,8,'2026-07-04','Pagi'),(100,4,9,'2026-07-04','Pagi'),(101,4,10,'2026-07-04','Pagi'),(102,4,13,'2026-07-04','Siang'),(103,4,14,'2026-07-04','Siang'),(104,4,15,'2026-07-04','Siang'),(105,4,16,'2026-07-04','Libur'),(106,4,17,'2026-07-04','Libur'),(107,4,18,'2026-07-04','Libur');
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jadwal`
--

LOCK TABLES `jadwal` WRITE;
/*!40000 ALTER TABLE `jadwal` DISABLE KEYS */;
INSERT INTO `jadwal` VALUES (2,2,'Jadwal Shift Minggu Kedua'),(3,3,'Jadwal Shift Libur Nasional'),(4,5,'Jadwal Shift (28 Jun - 04 Jul 2026)');
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `karyawan`
--

LOCK TABLES `karyawan` WRITE;
/*!40000 ALTER TABLE `karyawan` DISABLE KEYS */;
INSERT INTO `karyawan` VALUES (1,'KR001','Andi Saputra',NULL),(2,'KR002','Budi Santoso',NULL),(3,'KR003','Citra Dewi',NULL),(4,'KR004','Dewi Lestari',NULL),(5,'KR005','Eko Prasetyo',NULL),(8,'KU008','hello','P'),(9,'KU009','hello','P'),(10,'KU010','yantois','L'),(13,'KU013',' a s d','L'),(14,'KU014','a','L'),(15,'KU015','a','L'),(16,'KU016','a s d','L'),(17,'KU017','a s d','L'),(18,'KU018','andri','L');
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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pembuat_dan_karyawan`
--

LOCK TABLES `pembuat_dan_karyawan` WRITE;
/*!40000 ALTER TABLE `pembuat_dan_karyawan` DISABLE KEYS */;
INSERT INTO `pembuat_dan_karyawan` VALUES (1,1,1),(2,1,2),(3,1,3),(4,2,4),(5,3,5),(8,5,8),(9,5,9),(10,5,10),(13,5,13),(14,5,14),(15,5,15),(16,5,16),(17,5,17),(18,5,18);
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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-06-16 15:42:52
