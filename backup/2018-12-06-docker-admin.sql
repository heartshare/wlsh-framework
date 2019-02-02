-- MySQL dump 10.13  Distrib 8.0.12, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: lims_hk
-- ------------------------------------------------------
-- Server version	8.0.13

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
 SET NAMES utf8mb4 ;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `face_admin_backup`
--

DROP TABLE IF EXISTS `face_admin_backup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `face_admin_backup` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `file_name` varchar(50) NOT NULL DEFAULT '0',
  `file_size` int(10) unsigned NOT NULL DEFAULT '0',
  `file_md5` char(32) NOT NULL DEFAULT '0',
  `crt_dt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='数据库备份文件信息';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `face_admin_backup`
--

LOCK TABLES `face_admin_backup` WRITE;
/*!40000 ALTER TABLE `face_admin_backup` DISABLE KEYS */;
/*!40000 ALTER TABLE `face_admin_backup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `face_admin_menu`
--

DROP TABLE IF EXISTS `face_admin_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `face_admin_menu` (
  `id` tinyint(4) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `upID` tinyint(4) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT='主菜单';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `face_admin_menu`
--

LOCK TABLES `face_admin_menu` WRITE;
/*!40000 ALTER TABLE `face_admin_menu` DISABLE KEYS */;
INSERT INTO `face_admin_menu` (`id`, `name`, `icon`, `url`, `upID`, `level`) VALUES (5,'日志中心','&#xe6b8;','view/log',0,1),(7,'系统管理','&#xe6b8;','view/system',0,1),(16,'主菜单设置','&#xe6b8;','view/system/menu_list.html',7,2),(20,'系统用户设置','&#xe6b8;','view/system/user_list.html',7,2),(21,'swoole日志','&#xe6b8;','view/logSwoole/swoole_list.html',5,2),(25,'更新服务器数据','&#xe6a2;','view/system/pull.html',7,2),(26,'数据库备份/恢复','&#xe6a2;','view/system/db_list.html',7,2),(27,'前端平台管理','&#xe6a2;','view/admin',0,1),(28,'平台用户设置','&#xe6a2;','view/admin/user_list.html',27,2);
/*!40000 ALTER TABLE `face_admin_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `face_admin_user`
--

DROP TABLE IF EXISTS `face_admin_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `face_admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `cTime` timestamp NULL DEFAULT NULL,
  `remark` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `face_admin_user`
--

LOCK TABLES `face_admin_user` WRITE;
/*!40000 ALTER TABLE `face_admin_user` DISABLE KEYS */;
INSERT INTO `face_admin_user` (`id`, `name`, `pwd`, `status`, `cTime`, `remark`) VALUES (1,'ceshi001','$2y$10$Ih54W3EORACrFQSXpRyWfO.150mfV4MK4lTis.sMwRNKLTCGeLa9O',1,'2018-10-24 17:59:38',''),(2,'face789','$2y$10$k2uqI5g.NkVggZbjb48/gu7axGMLRftjdAy4FCris2zwxuE4xmWFW',1,'2018-10-09 17:47:34','旷视测试用');
/*!40000 ALTER TABLE `face_admin_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `face_admin_user_log`
--

DROP TABLE IF EXISTS `face_admin_user_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
 SET character_set_client = utf8mb4 ;
CREATE TABLE `face_admin_user_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` int(10) unsigned DEFAULT NULL,
  `lTime` timestamp NULL DEFAULT NULL,
  `eTime` timestamp NULL DEFAULT NULL,
  `lip` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `face_admin_user_log`
--

LOCK TABLES `face_admin_user_log` WRITE;
/*!40000 ALTER TABLE `face_admin_user_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `face_admin_user_log` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-06 15:51:38
