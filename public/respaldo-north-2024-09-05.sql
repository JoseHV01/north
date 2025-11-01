-- MariaDB dump 10.19  Distrib 10.4.20-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: north_qa
-- ------------------------------------------------------
-- Server version	10.4.20-MariaDB

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
-- Table structure for table `asks_security`
--

DROP TABLE IF EXISTS `asks_security`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asks_security` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `ask` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asks_security`
--

LOCK TABLES `asks_security` WRITE;
/*!40000 ALTER TABLE `asks_security` DISABLE KEYS */;
INSERT INTO `asks_security` VALUES (1,1,'¿Como te llamas?','eyJpdiI6Ik9ZYzN4NStINkVmVU9NQ1dpRGg4c3c9PSIsInZhbHVlIjoiRnZCR3VrZXkwd0NDeXlqTStqOElQQT09IiwibWFjIjoiMDZkYjIzMzBhOGZmYjVhMzc0ZmE0YWQ2NWY1NjRkNzFhM2E3N2U3M2ZiZDIxOTgyZjU3ZWU0ZDhhZjczMjVlOSJ9',NULL,NULL),(14,1,'¿Como te llamas?','eyJpdiI6Iks4TkcwbmVXTG1GUUJYWjJMUkdyYXc9PSIsInZhbHVlIjoiellyRHZISUlWaTZZdW9IdUJQQmdhZz09IiwibWFjIjoiY2Y4NzYyYmRiNWIzNGNjMzM1MjllOGM1NDQwMTYyNTRjOTMwNmE4N2ZmYzA4MmNmODA2ZDA3NzAzYmFlZmE2ZiJ9',NULL,NULL),(15,1,'¿Como te llamas?','eyJpdiI6IitITVRBbGxUdDM4ZG5Ya1JQRjJTQXc9PSIsInZhbHVlIjoiQ2NjL0xERDM3RXBGV0NIajRzWWw1Zz09IiwibWFjIjoiZWU4ZjgwODUwOTU1NjU4NWEzZTdiZGY2OTg2MmI0ZDBjODFiZDMzNjk0MmVlOTIzNzI3NzRjYTY2OWU3NDYyNSJ9',NULL,NULL),(17,2,'¿Como te llamas?','eyJpdiI6Im9ueTVjSXZSZHRLcWJKcDJLTEJSdGc9PSIsInZhbHVlIjoiZWRsQ0ljTHlnV0FrU2dqQnR6SWE5Zz09IiwibWFjIjoiN2NhYzZjNjA1MzcwMzNkMjdmMTU3Yjg1NWU2MjZkM2E5Y2ViMzM1Yjg5Y2JhZGQ5NDI5MjEyZTdkZThhY2JhMiJ9',NULL,NULL),(18,2,'¿edad en el 2023?','eyJpdiI6Im5TSVQ1M2o4UTBwMUZMMEVzK0tBdkE9PSIsInZhbHVlIjoiUVR0VE5SOXRvb2xqU0V6RU5QTDVBdz09IiwibWFjIjoiZGZmY2EyNjQyNjQwN2JhMTlkZDRkMWY2MDUzZTA0ZWQzMWNlODI3MzVhYjY1ODAyNjc2ZDk1NGMxYzdlMGJjYiJ9',NULL,NULL),(19,2,'¿perrito?','eyJpdiI6IjFtQXMxQkpydS93SDl6dWswdGorRVE9PSIsInZhbHVlIjoiV1lXbXJGVzNoR0k1VnBpbXNsbXBBQT09IiwibWFjIjoiMjVmZTY2MmM4YWY1NTMzNzY0NGYxNjBiNmM1NGUyNjk3YWM4YzI5YWJkYTZhMjFlOTczYmIzMjY5ZmEzZTBiMyJ9',NULL,NULL),(20,4,'tu edad en 2023','eyJpdiI6IlBRSlZjYmZXdUpFVGdJYnZQTGFaU0E9PSIsInZhbHVlIjoiejZXb2RzTG1OUmFuM1NIWitTS2RRQT09IiwibWFjIjoiODNlNTBkZTRhNTE1MmEyOWYzOGQxY2M3YTU3YzcwNTNiNTNiZDkwM2IyOTM5ODRhMGJjMTc4NzUxNzVkZDBhMyJ9',NULL,NULL),(21,4,'nombre de tu mama','eyJpdiI6ImRyNmhFREF2ZXpIR0ErMzBxZG9vN2c9PSIsInZhbHVlIjoiSnpEYjRIbFdnUUlidEdwczZSc2RNMFVuUWFJRlNIYURuZ3d1VlVMZi9vWT0iLCJtYWMiOiJhMTQzMzkxZjU0M2NmZGM1MjgwYjQ1YjFiNDFhNWQwNzYwOGZiOTU0YTc2Yzg4NjQ1YjU5Yzk1MjMwOGUzMDA1In0=',NULL,NULL),(22,4,'heroe favorito','eyJpdiI6IllqNWNiaUNLUTZLT3BodEI2ZENMT0E9PSIsInZhbHVlIjoiWHgwU2UxWXBzRnNXM25ZdzM4eFhXZkJERnZVM2xrYTRIK3JPQXgxcXYwWT0iLCJtYWMiOiIzNTRiYmEzN2Q2MDNjMGUxZWVkYzcyOGIzNWIxYWZmMDI1NDBiMjM0NTlkYzk5ZTcxMzI2YjU1NmI1MzA1ZDcyIn0=',NULL,NULL),(23,5,'como te llamas','eyJpdiI6ImlFb09yVmE3b0dHUDNmNEtiQjhLYkE9PSIsInZhbHVlIjoiV2pEVjlSak9FL1VyQVM0OCtpZmhhUT09IiwibWFjIjoiNjI5MjI0ZTNmNGJiYjlmZDJjNzIzYWMwMjIxNTg1ODYxMDgyNGM0YmVkM2RmODI0MzExMjc5NmE2ZTk5ZGVjNyJ9',NULL,NULL),(24,5,'como te llamas','eyJpdiI6IjJTVzcwT2pibjhRUUJhOWdnY3pRTnc9PSIsInZhbHVlIjoiSTFDNWhFS2xWNEJ1N3krV0cwWi9nZz09IiwibWFjIjoiMDYwMGJmODUwMjI4NDQ0NmNmZWQ3ZmJmNDg4OTU4YTljNmIxMDU0M2UyZWRlYTAxMmJjZGFhYzZhZjA3YjJmYyJ9',NULL,NULL),(25,5,'que edad tienes','eyJpdiI6Ik5KWWtEc0pDVkpUZ3Z5a0NyZUJFRlE9PSIsInZhbHVlIjoiTUxXZk1tVUkzaHRXMDBpMnU2TkdEQT09IiwibWFjIjoiMjg5ODhmM2ZkMzVhYmI3YzNkNzllM2RmOGQ5YWY4YmUxZGM2MmQyNmMzODY1YmQzN2MzZTczNzVhYjM1NTlkMyJ9',NULL,NULL),(26,6,'mascota','eyJpdiI6IlNRYTl2bGZ4S3hYMXFYeUtONFVXVEE9PSIsInZhbHVlIjoiT0hrLy9raEZ4a2hMMUlQUldUZ0J4dz09IiwibWFjIjoiMDIwOWRiNTg2NzY3ODMxNzZhOTZmNGY5NzIyYWU0OTJmOTYwZWFiOGY3NzVjYTJmZjdiNTQ2MWZlZmI2N2U5OSJ9',NULL,NULL),(27,6,'mascota','eyJpdiI6IjQ3RCtXdkluY2JzQktiSE5ZSTZTOHc9PSIsInZhbHVlIjoiTk05SGw2bzM1Z1o5R3ZSdGxXU2hudz09IiwibWFjIjoiNDc3NmU0MjhjZTNjMTNhZDI4MDdmYWQ1MjNkYTJkYjdhY2UwMGNlZGRhMGVkMTI2YzQxMjg0Njk3MWI1Yzk3MSJ9',NULL,NULL),(28,6,'mascota','eyJpdiI6Inl3M3RGVGNBL1BIclYycy8rK0xucnc9PSIsInZhbHVlIjoiUGlISG9RQldNRjlHbFR3SThhcTBBZz09IiwibWFjIjoiMjM1OGM0MzdiOWM3ZDhlMGQ0OGZlMTU2ZDEzYzU3OGNjYzY4ZjJjNDE0OWE5M2JhY2M4Mjc2NGNmMzdhNDY0NSJ9',NULL,NULL),(29,7,'comida','eyJpdiI6ImlGczEzMGZ6aHd2OGRyOWdRaGNpTFE9PSIsInZhbHVlIjoiTFFnSlloMXZ2VEkvcWhiNGtJckdVUT09IiwibWFjIjoiNDVlYTExY2NjNGYwMDg3ZWQ4ZmEwNjNjZWJhZjg0ZTYxNDgxZjA1N2Y1YzdhZWNiNGM3N2Q3ZjEzODE5YmI0NSJ9',NULL,NULL),(30,7,'comida','eyJpdiI6Ik9wclFQYjF1WFVEc2VLTXQvc2hrbUE9PSIsInZhbHVlIjoiWVdEeDJEMnBMbVY4WDVBOFQxaFFqUT09IiwibWFjIjoiMWY5NzE2N2ZlYzQwNzY4ZDY1ZjA2MjViMGZmZGQ0YzYyYmQxY2ZhMzYyN2VmOWY0MDdhMzBiYmVmNjc3NjY0MiJ9',NULL,NULL),(31,7,'comida','eyJpdiI6IjVFb3dLNVRvaFZNbjB1aU8raGtRS2c9PSIsInZhbHVlIjoib1JZMHp3U0Q0K1FNSm81bGgwYVFjUT09IiwibWFjIjoiMjJkZTQ2MzBjNmU1ZDcwMTRiZTVkYjY0MTViNjQwZWQxMTljZmYxNjFhMDNhM2Y2YmUzNjExMWY2NzM1YTA4OSJ9',NULL,NULL),(32,8,'comida','eyJpdiI6IjRQWGppbjVLc2Nqc3JyS0dPclQyT2c9PSIsInZhbHVlIjoidzBuTElGRGkyMERIVFl2SFBxZ051Zz09IiwibWFjIjoiN2ZiYzU2OGQ5MTQzMjk3NGQ2ZTU5YmFhNjJmMmRmYmQzMDQ0YmY4MTA3Y2UzNDczODJjMTY1MGFhNDY4MzFjNyJ9',NULL,NULL),(33,8,'comida','eyJpdiI6ImpUSTVwMHpzTTAvZFlnT2dNSDJJV3c9PSIsInZhbHVlIjoiTE1aK3JCdGV1N2tja0lBb3NXVjhKdz09IiwibWFjIjoiZjQ0N2U2NWU3YjFlYjhlMDU3MmFjMGM1Y2NjYzQ5OWI4ZTk0MDZmNGQ5N2FiODBmMzhlMTg0MjE2Y2IxYjVlMyJ9',NULL,NULL),(34,8,'comida','eyJpdiI6IjZiclhkWFJNcWVmOFRpSThIcDdlaXc9PSIsInZhbHVlIjoiSGdscmxSQU1SdXFwQnNPTmhDQ2JuZz09IiwibWFjIjoiZGVhYWVmOTk1MGMyOGFjZmE5NDY5MDQ4MzI5MTk4MWQ1MTI1ZTc0YTFhM2M1NjA2M2EzODgwOTQ1YTUyYTk3MiJ9',NULL,NULL),(35,9,'asasa','eyJpdiI6InhEUExjL3kwcmRCYldpbnFEdGI3Unc9PSIsInZhbHVlIjoiYnVBWi9IbU9wUGZiUGtiVlIrMmNyZz09IiwibWFjIjoiOTVmNmVkZDEwNmFhNTBmMzA4YjRjZWRiOTI4MmJjNTk0ZDdlNWIwNDBhNTUyM2FlOTc4NGYzMTM3YTAzZTYxOSJ9',NULL,NULL),(36,9,'asada','eyJpdiI6IjBlWTJVK3d6Mmd2MjFaVTBOWmloY1E9PSIsInZhbHVlIjoiMG5kTnhSTXk0Nzh2U0V4ZzdHc29xQT09IiwibWFjIjoiNjc5MjljMDU2NjQyOGQ1YmI3ZWJmNDU0OGRhYzBlNjk0NWM3Y2MyNDkyNzFlZDlkMDUyNGI0YTI3ZWVjYTBmMiJ9',NULL,NULL),(37,9,'asasa','eyJpdiI6IlF1N2FycUtXczJDQ3pYRnhPWklvT2c9PSIsInZhbHVlIjoiWGNKRDdXOGprSnhnVUFzcDQ3WGJ4UT09IiwibWFjIjoiYTBkMzlhYjFhMDBlMDI3NTYwNWEwMmYzYmY3MTNmNzFiNzg0Yjg4NDE4MWM1OWNhOWJmM2YxNWMyYzhhMjIxNiJ9',NULL,NULL),(38,10,'asasasa','eyJpdiI6IkxDcWMyNkpFOVlXQ1lGY3NGdURkMnc9PSIsInZhbHVlIjoiRjU4NmdqNVloSDkwZ1VueDJXNThXUT09IiwibWFjIjoiNzc3OGZjY2Y0NmQ2OTQ1NTg4NzQ1ZDdhNjBhNGM5ZWVjMDM5Yzg0NGZkZDZjMDQ0NmQ2NGI2ZDcwMjE2M2ViYSJ9',NULL,NULL),(39,10,'asasasa','eyJpdiI6IkdzTFZyb09EcUQ3c3lxM2FMZitNbWc9PSIsInZhbHVlIjoiYktJNURwR1pjTWUrT3lrT05yM0t3UT09IiwibWFjIjoiYjZjN2U1YzRhMmZkNzY2NjAyZTk5N2RlYjI0NmE3OTNlNjM1MWI5YzZjZmNjYzhmN2UzM2M3ZDQyZmQ2OWRkZCJ9',NULL,NULL),(40,10,'asasasa','eyJpdiI6Ik9zUWxVUTZrUzl1elY2eVZrQzVtQ0E9PSIsInZhbHVlIjoiSWZjRUhESDJYemlBdXZMTHBPc0pSZz09IiwibWFjIjoiOTJiYzNkZjBhODU3ZjkyMWRjYzU1ZWZhMDFiZmIyNjk2YWVkYTg0NzM3NTU5ZWUxOWVmYWIyNDllYWVjZGJlOCJ9',NULL,NULL),(41,11,'asasasas','eyJpdiI6IlhYbW44cENsU2IvV1FKak1qVlFBU1E9PSIsInZhbHVlIjoiTnhYNkNEY0dRWHpSZlJFWmJpK1lMUT09IiwibWFjIjoiY2UzODA5YzRhNmI2NDI2MzMyY2YyYmI2NTI1NzI2MDg1NDQyYTE3M2ExOTY5YzVkYzVhZWI1ZjRhZDExYjA3ZCJ9',NULL,NULL),(42,11,'asasasas','eyJpdiI6InI3S3Y5UGFDRmE4d1lOc05UZitncEE9PSIsInZhbHVlIjoiaEpOeUFGOWkyK1VLYXNBMENuTUNsQT09IiwibWFjIjoiMWJmYTE3MzZmMWI5ZTNiZWM4ZGI1NGMwOWE0ZWQ2YmZlY2VmYzE3NjZhMGI0MTgyYmIwMGE5N2MwZDBmZGI1ZiJ9',NULL,NULL),(43,11,'asasasas','eyJpdiI6InIwdGdLNXdQSUk1MkpXMWw2N1kxWHc9PSIsInZhbHVlIjoiZXVHV1dVdUh5TEJmckR0ZlRnbzlCdz09IiwibWFjIjoiMWMzZTY5MDE5NmExZjdhMzljNzcyNTA0MmY0NzBiN2FlY2M0ZWJhZjZmMzU0YzhiMjU3MzBkMjg2YmJkZTVjZCJ9',NULL,NULL),(44,12,'mango','eyJpdiI6Ik1nV3JLT01uZXYvbWJKQTAvKzM0MVE9PSIsInZhbHVlIjoiVGc4U1JkemU0dnp3bzdpL3FTdVNDQT09IiwibWFjIjoiNzEyY2M2NzYxNjYxZDZjNDY0YzNiMGE1OWNhOWU1ZGRkODA3ZWNmODJiY2Y2MWVlYmI0NWJhNWFlNzg5NmNjYSJ9',NULL,NULL),(45,12,'mango','eyJpdiI6ImRXQjBNNUJKY05PSHV4MFBuSnV0eGc9PSIsInZhbHVlIjoiODRYN0EzTmkwcWo2c1RPaENDOHJ6Zz09IiwibWFjIjoiM2ZhYjQzM2RjMmMwZjNkMTg1ZTcxODY5OTE4ZjNkZGMzMDAzZDE5YTIwNDZlZjA2YjkyZGRjNTc2YTdhMjFkOSJ9',NULL,NULL),(46,12,'mango','eyJpdiI6IndNRGVSM1VSckNaVGdIcmNmSFpsOUE9PSIsInZhbHVlIjoiSmd4b2M0T0wrUm85bVI1Y2JwNUQxQT09IiwibWFjIjoiYWQ4ZWJhMmRkMTY1MjRmZGY1Njk5ZWE5ZDliOGNhM2U3MDA2YmViMGQxMjY4MWMwZDUxOTg1YzIxMjdhZTUzYiJ9',NULL,NULL),(47,13,'asasas','eyJpdiI6IlBSNXR6NE9mZWNBdzkyeHcwV3pmTmc9PSIsInZhbHVlIjoiTnRyR0xySmYzbDFaaVFlcjFNaXp5dz09IiwibWFjIjoiNTE0Zjc4OGY5MmEyNTczZjhlNjIzMDBhZDdkYzNmZmRjZjNhZGVhNmFlNWNmYmYyOWNlMzUzMWI4YTg3YTE1MCJ9',NULL,NULL),(48,13,'asasas','eyJpdiI6IlZ4TWh1UTdYWWpoZDFNUVo4cDJDY0E9PSIsInZhbHVlIjoidzlsVVdQWERHMExuZkZOR3cxdjFyZz09IiwibWFjIjoiMjNkZWNmNTg4YjJmMzM2NGM2OGJhZjJjMzVkY2QxMGNmMGI0ODBmZDc2ZTY0NWVhOWViZTc2ZDM1MzUzMDM5ZCJ9',NULL,NULL),(49,13,'asasas','eyJpdiI6Ijd5b3daOWhma0hZV0dwdmg4ZE1VNHc9PSIsInZhbHVlIjoiZ09IOEQ2SDBmUmhqV1cyUURIL2JYdz09IiwibWFjIjoiZDMxZTQwY2ViMWFiMzVjMTQxMmY4NDBjODE3NjlmNmE4OTdjYjQzMTJlNGY2MjNiOGY1ZDY0MWVkZThlOGM4MiJ9',NULL,NULL),(50,14,'masasasas','eyJpdiI6Imt5bHg4VEhOcXJYWWxhY2tzMytDdVE9PSIsInZhbHVlIjoiLzJ5SDRQYmZEYTlNMEVqVnZuc3ZlK2toekJtUVBYQUtxNGZRWmsxcUt5RT0iLCJtYWMiOiI3YmUyYWJlYWZjZTQwNzc5NGQzNDNkMTcwNWRkNmQyZDUxMGM3NzcyYmZiNmQyYzBkNzI3NGIzYzYyNWZjNmRmIn0=',NULL,NULL),(51,14,'masasasas','eyJpdiI6IkhJemV6NGRhYlEvaHJsdXFPMXFvcEE9PSIsInZhbHVlIjoiS2tpRjZPL2lyVnFucm05aXd1bGRrc0VtNzd3Y2VnRGpZMlFWMWRRd2ZlTT0iLCJtYWMiOiI0ZGY2ODU0MjZmMmZiYjdhZmRjYzY1YjJkMzAxMzk4ZDdmNjY2ZjU3ZTkzZWUxNWU1NjhmMDM3NTUyY2JkYWIyIn0=',NULL,NULL),(52,14,'masasasas','eyJpdiI6IjNKMlRCVGtHa2tXZjNmajJQTWNYM3c9PSIsInZhbHVlIjoiN0VsOHJOTStNR0p6dmZUVWZ4eDNCaHdqWC9FdzIxWlJmWk56QW1PT2ZSbz0iLCJtYWMiOiIwNzE3OTkyNmYwZTFkMzc0YzQzMGFmN2NkZWVhMjM3MDg5YTU2MDVhNTQwMmM0ZDQxYjgzZWY2YmY5YjllOTdmIn0=',NULL,NULL),(53,15,'masasasas','eyJpdiI6IkFCc0N3V0dJakNyaFVsb2RMSmYrVEE9PSIsInZhbHVlIjoiSmdMMUl5V3Ara3Z0bXQzOHQwdmwwc1gvYU5CYTdiZzNnZDBuSVVoMExrTT0iLCJtYWMiOiJiY2QzZWI0YmQ5Y2EyYzNjMDEyMWYyMGNmNzM0MjIzNWYwMzA5YWY2NzFmY2U2YThkMDRkODI4YjU3YThiNGU4In0=',NULL,NULL),(54,15,'masasasas','eyJpdiI6IkZ6KytCYm9KVHJmMXBsMGZKa3R6VkE9PSIsInZhbHVlIjoiYzgzbHZtYzRGYWJDalRNUE9ocWR5RUova3Qzbm9UWnZwbUdDN3Q4WVBRbz0iLCJtYWMiOiJiZGM4MTcxMzRiMjAzMWViMjY0NDljNjZkNGFhNDIwNDExMzBmNTAxNWRlZDQ0MzE2YjhkNmY0ZjUwOTE3YmZmIn0=',NULL,NULL),(55,15,'masasasas','eyJpdiI6ImVCQ2oxYXdHbDROSUh4QVdVVGZEZmc9PSIsInZhbHVlIjoidGZLSTMzTXZteHZBQmtkWUoxTnVMaGZxaW1xL3ZCV29VU3hTanAwbFdPWT0iLCJtYWMiOiI1N2ZmY2MwMWUwMDdkMTM5OTZhN2QzNmQ1YmVmNjI2MjAyMmYyZmFiMDIyYTBjMDI2ZDgxMmM5ZWJlMmJlZTljIn0=',NULL,NULL),(59,16,'pregunta 1','eyJpdiI6Imc2VG80QmtZc2xGSk1zaW50eUJ6b2c9PSIsInZhbHVlIjoiYVR3WG5VQmhLRENOTTM3YTBGQ2YvTEdVaUdNbndPOW1EOTh2K2poNUZWcz0iLCJtYWMiOiI1MTU2MzI0M2Y4ZmRhNGZhZjBlMTU2NTIzYTY2ZjdiNWQ5YTNmYWY2MmQzZDBjNWI3MzgwN2U5NjlhYWI1Mjk4In0=',NULL,NULL),(60,16,'holas','eyJpdiI6InFQdGhsYXJpZUlSSjV2bHFMbG1CNGc9PSIsInZhbHVlIjoidytFK1BVVVU0RmtEUVIvVlRNWXNtQT09IiwibWFjIjoiMGM2N2U0ZTJlN2JhNjE1ZGIzNmQ3YzZiMzExNGZkNDViYWNiNzQ4MzhhNWQwOTQ0ZWM1NTlkOGM1NmU5M2NlMiJ9',NULL,NULL),(61,16,'holas','eyJpdiI6IlhUdDFIeTNzektkWFdraCs2eExWU0E9PSIsInZhbHVlIjoiNEJrUTM1ZHpjUFpZdEVoWkd3Mjl2Zz09IiwibWFjIjoiZGQ3NTY5M2E0MTlhYjY3NzZmNTY5M2U4YmQ4ODBiOWJlNzcxMTMwMmNkMzY2NTQ4YWJhMjA4ZWFjZjY1ZWMxOCJ9',NULL,NULL),(62,17,'asjkajsk','eyJpdiI6InJSM1ZPRStMb242enIycEZxRmZzSUE9PSIsInZhbHVlIjoiZE0wU0lVZ3JsV0RpcmRZbWt1Vk5Odz09IiwibWFjIjoiMTJiM2Q3Y2IwZjdlNDY2OWZjYThjOWNiYjRiOWU4ZTViMmE4NTFhYTdkZjc1ODljNjc3ZjY2YTdmNjNiNzI2NiJ9',NULL,NULL),(63,17,'asjkajsk','eyJpdiI6IkdUK1p2Qlp2a3owcXRjdEZuQzM5VGc9PSIsInZhbHVlIjoiazl4NGQyUkUreEE0NHFrdld1cHNxQT09IiwibWFjIjoiMDMwNDc1OTA0Y2IzZGVjNTIxZWJlZTdkOTc5OWJiZjZhYzYzZDJiMjNkZjdiMDI3MWYyNWEyYjlhYTk2NTE0YiJ9',NULL,NULL),(64,17,'asjkajsk','eyJpdiI6Illkd016WjNvd3hSTHYzVS85WGxsbGc9PSIsInZhbHVlIjoiRVg5K3ZIcGlORVBZY1JOa3RpWW4zQT09IiwibWFjIjoiMjhlNjk5Njc2MDQxNjM1NDUyMTkxN2Y5NGM1NzZlZTM3Y2Y5Mzc1MzQyNTBhNzEyMjcwMGZlMmUxZTc2MDk0NSJ9',NULL,NULL);
/*!40000 ALTER TABLE `asks_security` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categorys`
--

DROP TABLE IF EXISTS `categorys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorys` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorys`
--

LOCK TABLES `categorys` WRITE;
/*!40000 ALTER TABLE `categorys` DISABLE KEYS */;
INSERT INTO `categorys` VALUES (1,'escritura',1,NULL,NULL),(2,'papeleria',1,NULL,NULL),(3,'manualidades',0,NULL,NULL),(4,'menudos',0,NULL,NULL),(5,'categoria nueva',1,NULL,NULL);
/*!40000 ALTER TABLE `categorys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company`
--

DROP TABLE IF EXISTS `company`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `rif` varchar(255) NOT NULL,
  `direction` varchar(255) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_At` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_At` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company`
--

LOCK TABLES `company` WRITE;
/*!40000 ALTER TABLE `company` DISABLE KEYS */;
INSERT INTO `company` VALUES (1,'Centro de Copiado Integral','V-27890234-0','Calle Hurtado Ascanio, Edif, San Judas Tadeo, Piso PB, Local 1 Sector El Cumbito - Altagracia de Orituco - Estado Guarico','04243450001','centrodecopiadoaltagracia@ejemplo.com','2023-11-03 18:35:44','2023-11-03 18:35:44'),(4,'Centro de Copiado Integral','V-27890234-0','Calle Hurtado Ascanio, Edif, San Judas Tadeo, Piso PB, Local 1 Sector El Cumbito - Altagracia de Orituco - Estado Guarico','04243450001','centrodecopiadoaltagracia@ejemplo.com','2024-04-05 23:10:04','2024-04-05 23:10:04'),(5,'Centro de Copiado Integral','V-27890234-0','Calle Hurtado Ascanio, Edif, San Judas Tadeo, Piso PB, Local 1 Sector El Cumbito - Altagracia de Orituco - Estado Guarico','04243450001','centrodecopiadoaltagracia@gmail.com','2024-09-05 23:36:04','2024-09-05 23:36:04');
/*!40000 ALTER TABLE `company` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customers`
--

DROP TABLE IF EXISTS `customers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_document_type` int(11) NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `phone_secondary` varchar(11) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customers`
--

LOCK TABLES `customers` WRITE;
/*!40000 ALTER TABLE `customers` DISABLE KEYS */;
INSERT INTO `customers` VALUES (1,0,'0','Sin Personalizar',1,'Sin especificar','Sin especificar','',NULL,NULL),(2,4,'1528634','vanessa navarro',1,NULL,NULL,NULL,NULL,NULL),(5,2,'11222331','Banco del Tesoro',1,NULL,NULL,NULL,NULL,NULL),(6,4,'9807223','Pedro Diaz',0,'pedro@gmail.com','04243452311',NULL,NULL,NULL),(7,2,'9023112','Maria Perez',1,'maria@gmail.com',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `customers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `document_types`
--

DROP TABLE IF EXISTS `document_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `document_types` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `document_types`
--

LOCK TABLES `document_types` WRITE;
/*!40000 ALTER TABLE `document_types` DISABLE KEYS */;
INSERT INTO `document_types` VALUES (1,'E -',NULL,NULL),(2,'G -',NULL,NULL),(3,'J -',NULL,NULL),(4,'V -',NULL,NULL);
/*!40000 ALTER TABLE `document_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `logs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) DEFAULT NULL,
  `module` varchar(255) DEFAULT '',
  `action` varchar(255) DEFAULT '',
  `data` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `logs`
--

LOCK TABLES `logs` WRITE;
/*!40000 ALTER TABLE `logs` DISABLE KEYS */;
INSERT INTO `logs` VALUES (1,2,'Productos','Insercion de registro','{\"descripcion\":\"asjka\",\"categoria\":\"escritura\",\"existencia minima\":\"18\"}','2024-09-01 17:04:10','2024-09-01 17:04:10'),(2,2,'Productos','Visualizacion de registros','null','2024-09-01 17:04:11','2024-09-01 17:04:11'),(3,2,'Ventas','Busqueda de registros','null','2024-09-05 22:48:27','2024-09-05 22:48:27'),(4,2,'Ventas','Busqueda de registros','null','2024-09-05 22:48:36','2024-09-05 22:48:36'),(5,2,'Proveedores','Visualizacion de registros','null','2024-09-05 22:51:07','2024-09-05 22:51:07'),(6,2,'Proveedores','Visualizacion de registros','null','2024-09-05 22:52:09','2024-09-05 22:52:09'),(7,2,'Proveedores','Visualizacion de registros','null','2024-09-05 22:52:37','2024-09-05 22:52:37'),(8,2,'Proveedores','Insercion de registro','{\"id\":null,\"tipo de documento\":\"G -\",\"documento\":\"90232312\",\"razon social\":\"El principe S.A\",\"telefono\":null,\"telefono secundario\":null,\"correo\":null,\"direccion\":\"cerca de la alcabala\"}','2024-09-05 23:02:54','2024-09-05 23:02:54'),(9,2,'Proveedores','Visualizacion de registros','null','2024-09-05 23:02:54','2024-09-05 23:02:54'),(10,2,'Clientes','Visualizacion de registros','null','2024-09-05 23:05:33','2024-09-05 23:05:33'),(11,2,'Clientes','Insercion de registro','{\"id\":null,\"documento\":\"G - 9023112\",\"razon social\":\"Maria Perez\",\"correo\":\"maria@gmail.com\",\"telefono\":null,\"telefono secundario\":null}','2024-09-05 23:09:59','2024-09-05 23:09:59'),(12,2,'Clientes','Visualizacion de registros','null','2024-09-05 23:09:59','2024-09-05 23:09:59'),(13,2,'Categorias','Visualizacion de registros','null','2024-09-05 23:17:54','2024-09-05 23:17:54'),(14,2,'Categorias','Insercion de registro','{\"id\":null,\"categoria\":\"categoria nueva\"}','2024-09-05 23:18:47','2024-09-05 23:18:47'),(15,2,'Categorias','Visualizacion de registros','null','2024-09-05 23:18:48','2024-09-05 23:18:48'),(16,2,'Categorias','Visualizacion de registros','null','2024-09-05 23:19:47','2024-09-05 23:19:47'),(17,2,'Formas de Pago','Visualizacion de registros','null','2024-09-05 23:22:35','2024-09-05 23:22:35'),(18,2,'Formas de Pago','Insercion de registro','{\"id\":null,\"forma de pago\":\"Tarjeta\"}','2024-09-05 23:23:50','2024-09-05 23:23:50'),(19,2,'Formas de Pago','Visualizacion de registros','null','2024-09-05 23:23:50','2024-09-05 23:23:50'),(21,2,'Tasas','Visualizacion de registros','null','2024-09-05 23:25:33','2024-09-05 23:25:33'),(22,2,'Tasas','Edicion de registro','{\"id\":null,\"tasa\":\"BCV\",\"valor\":\"38\"}','2024-09-05 23:27:10','2024-09-05 23:27:10'),(23,2,'Tasas','Visualizacion de registros','null','2024-09-05 23:27:11','2024-09-05 23:27:11'),(25,2,'Compania','Insercion de registro','{\"razon social\":\"Centro de Copiado Integral\",\"rif\":\"V-27890234-0\",\"correo\":\"centrodecopiadoaltagracia@gmail.com\",\"telefono\":\"04243450001\",\"direccion\":\"Calle Hurtado Ascanio, Edif, San Judas Tadeo, Piso PB, Local 1 Sector El Cumbito - Altagracia de Orituco - Estado Guarico\"}','2024-09-05 23:36:04','2024-09-05 23:36:04'),(26,2,'Compania','Visualizacion de registros','null','2024-09-05 23:36:04','2024-09-05 23:36:04'),(27,2,'Usuarios','Visualizacion de registros','null','2024-09-05 23:37:43','2024-09-05 23:37:43'),(28,2,'Usuarios','Insercion de registro','{\"nombre\":\"jaksjkaks\",\"correo\":\"jaksjkaks@gmail.com\"}','2024-09-05 23:46:21','2024-09-05 23:46:21'),(29,2,'Usuarios','Visualizacion de registros','null','2024-09-05 23:46:22','2024-09-05 23:46:22'),(31,2,'Bitacora','Visualizacion de registros','null','2024-09-05 23:47:04','2024-09-05 23:47:04'),(32,2,'Base de datos','Busqueda de registros','null','2024-09-05 23:57:32','2024-09-05 23:57:32'),(33,2,'Bitacora','Respaldo de base de datos exitoso','null','2024-09-05 23:58:18','2024-09-05 23:58:18'),(34,2,'Base de datos','Respaldo de base de datos exitoso','null','2024-09-05 23:58:21','2024-09-05 23:58:21'),(35,2,'Bitacora','Respaldo de base de datos exitoso','null','2024-09-05 23:59:39','2024-09-05 23:59:39'),(36,2,'Base de datos','Respaldo de base de datos exitoso','null','2024-09-05 23:59:42','2024-09-05 23:59:42');
/*!40000 ALTER TABLE `logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (139,'2014_10_12_000000_create_users_table',1),(140,'2019_08_19_000000_create_failed_jobs_table',1),(141,'2023_07_11_012215_create_ask_security_table',1),(142,'2023_07_13_125834_create_categorys_table',1),(143,'2023_07_29_212757_create_products_table',1),(144,'2023_08_03_233706_create_rates_table',1),(145,'2023_08_04_233254_create_roles_table',1),(146,'2023_08_19_222623_create_purchases_invoice_details_table',1),(147,'2023_08_19_223036_create_sales_invoice_details_table',1),(148,'2023_08_19_223520_create_sales_invoices_table',1),(149,'2023_08_19_224050_create_states_operation_table',1),(150,'2023_08_19_224303_create_forms_payment_table',1),(151,'2023_08_19_224505_create_customers_table',1),(152,'2023_08_19_224739_create_providers_table',1),(153,'2023_08_19_225014_create_purchases_invoices_table',1),(154,'2023_08_23_234044_create_document_types_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_category` int(11) NOT NULL,
  `iva` tinyint(1) NOT NULL,
  `existence` int(11) DEFAULT 0,
  `existence_minime` int(11) DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `price` double DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'crellones',3,1,109,NULL,1,11.11,NULL,NULL),(2,'lapiz',1,1,294,NULL,1,14.44,NULL,NULL),(3,'ajksjkaksj',2,1,0,10,0,0,NULL,NULL),(6,'asjka',1,1,0,18,1,0,NULL,NULL);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `providers`
--

DROP TABLE IF EXISTS `providers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `providers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_document_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `document` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `business_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_secondary` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `direction` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `providers`
--

LOCK TABLES `providers` WRITE;
/*!40000 ALTER TABLE `providers` DISABLE KEYS */;
INSERT INTO `providers` VALUES (1,'0','0','Sin Personalizar','Sin especificar','Sin especificar','',1,NULL,NULL,NULL),(2,'3','27384959','sumipaca','02123467890','sumipaca@hotmail.com',NULL,1,NULL,NULL,'caracas'),(4,'2','112341231','Emprendedor C.A','0426223224','hola@gmail.com',NULL,0,NULL,NULL,'Valencia'),(5,'2','113459011','Borrador S.A','04243451239','borrador@gmail.com',NULL,1,NULL,NULL,'San Juan'),(6,'3','234569022','El Principe','04123450912','distribuidora@gmail.com',NULL,0,NULL,NULL,'Sector Centro'),(7,'2','90232312','El principe S.A',NULL,NULL,NULL,1,NULL,NULL,'cerca de la alcabala');
/*!40000 ALTER TABLE `providers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases_invoice_details`
--

DROP TABLE IF EXISTS `purchases_invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases_invoice_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_purchase_invoice` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` double NOT NULL,
  `percentaje` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases_invoice_details`
--

LOCK TABLES `purchases_invoice_details` WRITE;
/*!40000 ALTER TABLE `purchases_invoice_details` DISABLE KEYS */;
INSERT INTO `purchases_invoice_details` VALUES (1,1,1,10,2,10,NULL,NULL),(2,2,1,100,10,15,NULL,NULL),(3,3,1,1,1,10,NULL,NULL),(4,3,2,199,7,10,NULL,NULL),(5,4,1,19,4,8,NULL,NULL),(6,5,1,109,10,10,NULL,NULL),(7,5,2,108,19,10,NULL,NULL);
/*!40000 ALTER TABLE `purchases_invoice_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchases_invoices`
--

DROP TABLE IF EXISTS `purchases_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchases_invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_provider` int(11) NOT NULL,
  `id_shape_payment` int(11) NOT NULL,
  `id_state_operation` int(11) NOT NULL,
  `total` double NOT NULL,
  `invoice_number` double NOT NULL,
  `date` date NOT NULL,
  `control_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchases_invoices`
--

LOCK TABLES `purchases_invoices` WRITE;
/*!40000 ALTER TABLE `purchases_invoices` DISABLE KEYS */;
INSERT INTO `purchases_invoices` VALUES (1,4,3,1,200,1012,'2024-03-15','1012',0,'2024-03-16 23:35:41','2024-03-16 23:35:41'),(2,5,3,2,100,1212,'2024-03-12','0912',0,'2024-03-16 23:40:01','2024-03-16 23:40:01'),(3,1,4,1,1200,12121212,'2024-03-13','12121',0,'2024-03-31 21:38:21','2024-03-31 21:38:21'),(4,1,4,1,100,1091,'2024-04-03','1991',0,'2024-04-06 00:07:32','2024-04-06 00:07:32'),(5,1,3,1,1902,1902,'2024-04-04','1902',0,'2024-04-07 00:20:46','2024-04-07 00:20:46');
/*!40000 ALTER TABLE `purchases_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rates`
--

DROP TABLE IF EXISTS `rates`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rates` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rates`
--

LOCK TABLES `rates` WRITE;
/*!40000 ALTER TABLE `rates` DISABLE KEYS */;
INSERT INTO `rates` VALUES (1,'IVA',16,1,NULL,NULL),(2,'Ganancia',10,1,NULL,NULL),(3,'IGTF',3,1,NULL,NULL),(4,'BCV',38,1,NULL,NULL);
/*!40000 ALTER TABLE `rates` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin','1',NULL,NULL),(2,'User','1',NULL,NULL);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_invoice_details`
--

DROP TABLE IF EXISTS `sales_invoice_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_invoice_details` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_sales_invoice` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `price` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_invoice_details`
--

LOCK TABLES `sales_invoice_details` WRITE;
/*!40000 ALTER TABLE `sales_invoice_details` DISABLE KEYS */;
INSERT INTO `sales_invoice_details` VALUES (2,2,1,10,7.689,NULL,NULL),(3,3,1,19,7.689,NULL,NULL),(4,4,1,79,7.689,NULL,NULL),(5,5,1,3,7.073,NULL,NULL),(6,5,2,3,8.547,NULL,NULL),(7,6,1,19,4.774,NULL,NULL),(8,6,2,10,8.547,NULL,NULL);
/*!40000 ALTER TABLE `sales_invoice_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sales_invoices`
--

DROP TABLE IF EXISTS `sales_invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sales_invoices` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_customer` int(11) NOT NULL,
  `id_shapes_payment` int(11) NOT NULL,
  `tax_base` double NOT NULL,
  `total` double NOT NULL,
  `iva` double NOT NULL,
  `igtf` double NOT NULL,
  `ganance` double NOT NULL,
  `id_state_operation` int(11) NOT NULL,
  `status` int(11) DEFAULT 0,
  `number_bill` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `bcv` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `id_header` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sales_invoices`
--

LOCK TABLES `sales_invoices` WRITE;
/*!40000 ALTER TABLE `sales_invoices` DISABLE KEYS */;
INSERT INTO `sales_invoices` VALUES (2,5,1,76.9,89.20400000000001,16,0,10,1,0,'0002','0',1,'2023-01-04 23:25:34','2024-08-04 22:03:28'),(3,5,3,146.11,169.48760000000001,16,0,10,1,0,'0003','0',1,'2025-02-24 20:20:00','2024-08-04 22:14:53'),(4,1,4,607.51,704.7116,16,0,10,1,0,'0004','0',1,'2024-03-24 20:21:27','2024-03-24 20:21:27'),(5,1,5,46.86,54.3576,16,0,10,1,0,'0005','0',1,'2024-03-31 21:43:22','2024-03-31 21:43:22'),(6,5,4,176.13,204.3108,16,0,10,1,0,'0006','0',4,'2024-05-06 22:50:42','2024-08-04 21:58:16');
/*!40000 ALTER TABLE `sales_invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shapes_payment`
--

DROP TABLE IF EXISTS `shapes_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shapes_payment` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shapes_payment`
--

LOCK TABLES `shapes_payment` WRITE;
/*!40000 ALTER TABLE `shapes_payment` DISABLE KEYS */;
INSERT INTO `shapes_payment` VALUES (1,'Biopago',1,'2024-02-04 23:42:02','2024-02-04 23:42:02'),(2,'Divisas',1,'2023-11-21 21:47:21','2023-11-21 21:47:21'),(3,'Efectivo',1,'2023-11-15 00:10:06','2023-11-15 00:10:06'),(4,'Pago Movil',1,'2023-10-06 23:43:53','2023-10-06 23:43:53'),(5,'Transferencia',1,'2024-02-11 00:28:02','2024-02-11 00:28:02'),(13,'ejemplo',0,'2024-03-31 21:01:05','2024-03-31 21:01:05'),(14,'Tarjeta',1,'2024-09-05 23:23:50','2024-09-05 23:23:50');
/*!40000 ALTER TABLE `shapes_payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `states_operation`
--

DROP TABLE IF EXISTS `states_operation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `states_operation` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `states_operation`
--

LOCK TABLES `states_operation` WRITE;
/*!40000 ALTER TABLE `states_operation` DISABLE KEYS */;
INSERT INTO `states_operation` VALUES (1,'Pagado',1,NULL,NULL),(2,'Pendiente',1,NULL,NULL);
/*!40000 ALTER TABLE `states_operation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock`
--

DROP TABLE IF EXISTS `stock`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_purchase_invoice` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price_sale` double NOT NULL,
  `exists` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock`
--

LOCK TABLES `stock` WRITE;
/*!40000 ALTER TABLE `stock` DISABLE KEYS */;
INSERT INTO `stock` VALUES (1,1,1,0,2.2222222222222,0,'2024-03-23 23:25:34','2024-03-23 23:25:34'),(2,2,1,0,11.764705882353,0,'2024-03-31 21:43:22','2024-03-31 21:43:22'),(3,3,1,0,1.1111111111111,0,'2024-03-31 21:43:22','2024-03-31 21:43:22'),(4,3,2,186,7.7777777777778,1,'2024-04-06 22:50:42','2024-04-06 22:50:42'),(5,4,1,0,4.3478260869565,0,'2024-04-06 22:50:42','2024-04-06 22:50:42'),(6,5,1,109,11.111111111111,1,'2024-04-07 00:20:46','2024-04-07 00:20:46'),(7,5,2,108,21.111111111111,1,'2024-04-07 00:20:46','2024-04-07 00:20:46');
/*!40000 ALTER TABLE `stock` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `stock_register`
--

DROP TABLE IF EXISTS `stock_register`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stock_register` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_stock` int(11) NOT NULL,
  `quantity_sale` int(11) NOT NULL,
  `id_sales_invoices` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `stock_register`
--

LOCK TABLES `stock_register` WRITE;
/*!40000 ALTER TABLE `stock_register` DISABLE KEYS */;
INSERT INTO `stock_register` VALUES (2,1,10,2,'2024-03-23 23:25:34','2024-03-23 23:25:34'),(3,2,19,3,'2024-03-24 20:20:00','2024-03-24 20:20:00'),(4,2,79,4,'2021-02-24 20:21:27','2024-08-01 23:05:00'),(5,2,2,5,'2024-03-31 21:43:22','2024-03-31 21:43:22'),(6,3,1,5,'2024-03-31 21:43:22','2024-03-31 21:43:22'),(7,4,3,5,'2024-03-23 21:43:22','2024-08-02 00:09:46'),(8,5,19,6,'2024-04-06 22:50:42','2024-04-06 22:50:42'),(9,4,10,6,'2024-04-10 22:50:42','2024-08-02 00:09:33');
/*!40000 ALTER TABLE `stock_register` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `id_rol` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `entry_intention` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Suilma Mata','suilma@gmail.com',1,'1',NULL,'$2y$10$5OerjqLbeixS1YJrP88nruSlwybVBROOPZ4MOxxiydwNdrHYZlw.a',NULL,NULL,NULL,0),(2,'Jose Hernandez','admin@gmail.com',1,'1',NULL,'$2y$10$dlplzYx.Lt7tlupGJ/QtROocOmxEcpUaYYL7dDij/cBBhDqJKihpC',NULL,NULL,NULL,0),(9,'michel','michel@gmail.com',0,'2',NULL,'$2y$10$Y8fYqCGVRN4CgbaHzrNXOuZXLj9dHo2b5Fls2BVDrj1P0gGm8HR/.',NULL,NULL,NULL,0),(10,'ejemplo','ejemplo@gmail.com',1,'2',NULL,'$2y$10$xmSVsx92YKUbg9qh83KpHORJ8yb/tghEMLLuNgrtM3mXKO7P3tT2q',NULL,NULL,NULL,0),(11,'asasas','adasda@gmail.com',1,'2',NULL,'$2y$10$1URDAgjwAVIAJX0E0RUvFuFOXlg91fhVgIe6jOoaFfjwqDAvsdjZO',NULL,NULL,NULL,0),(12,'mango','mango@gmail.com',1,'2',NULL,'$2y$10$KleQMhUprwIgNV6WuA2PAu09rJXCQaouzUdqUG.VMyPCn3duKtC6e',NULL,NULL,NULL,0),(13,'asasas','mango@gmail.coma',1,'2',NULL,'$2y$10$0C4zDRvsy4bULOiDREIez.HOV3XLzA/.eYxcvAwqFVjg0sCMPmiI.',NULL,NULL,NULL,0),(14,'masasasas','mango@gmail.comas',1,'2',NULL,'$2y$10$DbUWcaS89Z2EW81H9OwcsuN5QbwKIOXSpi4zcLqDbgbqoh0ZHoJlm',NULL,NULL,NULL,0),(15,'masasasas','masasasas@gmail.com',1,'2',NULL,'$2y$10$0N7XaScIR3oXVYZJwFNsoOPMtNKwHXyR1M.39cQExGT0wbzsqJdAW',NULL,NULL,NULL,0),(16,'jose','jose@gmail.com',1,'2',NULL,'$2y$10$dlplzYx.Lt7tlupGJ/QtROocOmxEcpUaYYL7dDij/cBBhDqJKihpC',NULL,NULL,NULL,0),(17,'jaksjkaks','jaksjkaks@gmail.com',1,'2',NULL,'$2y$10$/yAantq2YyLkYZD8y5AH8On0gMzQeTWEiXvpmdP5.mRpqidbvvyGC',NULL,NULL,NULL,0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_permissions`
--

DROP TABLE IF EXISTS `users_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` bigint(20) DEFAULT NULL,
  `permission` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_permissions`
--

LOCK TABLES `users_permissions` WRITE;
/*!40000 ALTER TABLE `users_permissions` DISABLE KEYS */;
INSERT INTO `users_permissions` VALUES (1,10,'Proveedores',NULL,NULL),(2,10,'Clientes',NULL,NULL),(3,11,'Compras','2024-08-17 23:25:01','2024-08-17 23:25:01'),(4,11,'Proveedores','2024-08-17 23:25:01','2024-08-17 23:25:01'),(6,16,'Compras','2024-08-17 23:25:41','2024-08-17 23:25:41'),(7,16,'Productos','2024-08-17 23:25:41','2024-08-17 23:25:41');
/*!40000 ALTER TABLE `users_permissions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-09-05 19:59:44
