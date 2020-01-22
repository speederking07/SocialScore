-- MariaDB dump 10.17  Distrib 10.4.6-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: socialscore
-- ------------------------------------------------------
-- Server version	10.4.6-MariaDB

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
-- Table structure for table `deed`
--

DROP TABLE IF EXISTS `deed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `deed` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deed`
--

LOCK TABLES `deed` WRITE;
/*!40000 ALTER TABLE `deed` DISABLE KEYS */;
INSERT INTO `deed` VALUES (1,'Lust',-20),(2,'Gluttony',-5),(3,'Greed',-10),(4,'Sloth',-2),(5,'Wrath\r\n',-8),(6,'Envy',-25),(7,'Pride',-12),(8,'Carrying an old lady across the street',20),(9,'Letting someone through the door',2),(10,'Careing for animals in the shelter',30),(11,'Giving blood',40);
/*!40000 ALTER TABLE `deed` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `perk`
--

DROP TABLE IF EXISTS `perk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perk` (
  `name` varchar(45) NOT NULL,
  `description` varchar(200) DEFAULT NULL,
  `threshold` int(11) NOT NULL,
  PRIMARY KEY (`name`),
  UNIQUE KEY `name_UNIQUE` (`name`),
  KEY `threshold` (`threshold`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perk`
--

LOCK TABLES `perk` WRITE;
/*!40000 ALTER TABLE `perk` DISABLE KEYS */;
INSERT INTO `perk` VALUES ('1% tax refund','Name says everthing',200),('Biedronka super client','5% discount in Biedronka',50),('Culture voucher','Free admission to the theater once a month',100),('Extra smile','A box of chocolates at the beginning of each month',500),('Health privilege','Priority in queue to the doctor',1000),('Sport voucher','Free ticket to the gym once a week',20),('Transport perk','Free 15 min public transport',300),('Unlimited internet','Unlimited internet after 8 p.m. on weekends',-40);
/*!40000 ALTER TABLE `perk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `PESEL` bigint(20) NOT NULL,
  `firstName` varchar(45) NOT NULL,
  `lastName` varchar(45) NOT NULL,
  `middleName` varchar(45) DEFAULT NULL,
  `sex` enum('M','F') NOT NULL,
  `birthdate` date NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `e-mail` varchar(200) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fatherPESEL` bigint(20) DEFAULT NULL,
  `motherPESEL` bigint(20) DEFAULT NULL,
  `socialScore` int(11) NOT NULL,
  `photo` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`PESEL`),
  UNIQUE KEY `PESEL_UNIQUE` (`PESEL`),
  KEY `fk_Person_Person_idx` (`fatherPESEL`),
  KEY `fk_Person_Person1_idx` (`motherPESEL`),
  CONSTRAINT `fk_Person_Person` FOREIGN KEY (`fatherPESEL`) REFERENCES `person` (`PESEL`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Person_Person1` FOREIGN KEY (`motherPESEL`) REFERENCES `person` (`PESEL`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` VALUES (31010164325,'Teresa','Kos',NULL,'F','1931-01-01',NULL,NULL,NULL,NULL,NULL,0,NULL),(67020403204,'Zuzanna','Roge',NULL,'F','1967-02-04',NULL,NULL,NULL,NULL,NULL,0,NULL),(86120131235,'Max','Walha',NULL,'M','1986-12-01','WrocÅ‚aw',NULL,NULL,NULL,NULL,0,NULL),(88020703217,'Stefan','Wysocki','Piotr','M','1988-02-07','Mostowo',NULL,NULL,NULL,NULL,0,NULL),(98020703216,'Marek','Bauer',NULL,'M','1998-02-07','RacibÃ³rz','marekbauer07@gmail.com','796412014',NULL,NULL,-10,'jpg');
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 trigger peselinsert
    before insert
    on person
    for each row
BEGIN
    DECLARE i INT DEFAULT 0;
    SET @pesel = NEW.PESEL;
    SET @ctrlsum = 0;
    WHILE i<11 DO
            SET @num = MOD(FLOOR(@pesel/POW(10, i)),10);
            SET @j = CONVERT(ELT(11-i, '1', '3', '7', '9', '1', '3', '7', '9', '1', '3', '1'), UNSIGNED INTEGER);
            SET @ctrlsum = @ctrlsum + @j*@num;
            SET i = i + 1;
        END WHILE;
    IF (@ctrlsum%10 <> 0) THEN SIGNAL SQLSTATE '45000' SET message_text = 'Incorrect PESEL'; END IF;
    SET NEW.sex = ELT(MOD(MOD(FLOOR(@pesel/POW(10, 1)),10), 2) + 1, 'F', 'M');
    SET @month = MOD(FLOOR(@pesel/POW(10, 8)),10);
    SET @pesel_as_string = CONVERT(@pesel, CHAR(11));
    IF(@month = 0 OR @month = 1) THEN SET @date = CONCAT(19, SUBSTRING(@pesel_as_string, 1, 6));
    ELSEIF(@month = 2 OR @month = 3) THEN SET @month = @month - 2; SET @date = CONCAT(20, SUBSTRING(@pesel_as_string, 1, 2), @month, SUBSTRING(@pesel_as_string, 4, 3));
    ELSEIF(@month = 4 OR @month = 5) THEN SET @month = @month - 4; SET @date = CONCAT(21, SUBSTRING(@pesel_as_string, 1, 2), @month, SUBSTRING(@pesel_as_string, 4, 3));
    ELSEIF(@month = 6 OR @month = 7) THEN SET @month = @month - 6; SET @date = CONCAT(22, SUBSTRING(@pesel_as_string, 1, 2), @month, SUBSTRING(@pesel_as_string, 4, 3));
    ELSEIF(@month = 8 OR @month = 9) THEN SET @month = @month - 8; SET @date = CONCAT(18, SUBSTRING(@pesel_as_string, 1, 2), @month, SUBSTRING(@pesel_as_string, 4, 3));
    END IF;
    SET @birthdate = STR_TO_DATE(@date, '%Y%m%d');
    IF (@birthdate > CURDATE()) THEN SIGNAL SQLSTATE '45000' SET message_text = 'This person has not been born yet'; END IF;
    SET NEW.birthdate = @birthdate;
    SET NEW.socialScore = 0;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `persondeed`
--

DROP TABLE IF EXISTS `persondeed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `persondeed` (
  `deed` int(11) NOT NULL,
  `person` bigint(20) NOT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`deed`,`person`),
  KEY `fk_Person_has_Deed_Deed1_idx` (`deed`),
  KEY `fk_Person_has_Deed_Person1_idx` (`person`),
  CONSTRAINT `fk_Person_has_Deed_Deed1` FOREIGN KEY (`deed`) REFERENCES `deed` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Person_has_Deed_Person1` FOREIGN KEY (`person`) REFERENCES `person` (`PESEL`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `persondeed`
--

LOCK TABLES `persondeed` WRITE;
/*!40000 ALTER TABLE `persondeed` DISABLE KEYS */;
INSERT INTO `persondeed` VALUES (3,98020703216,'2020-01-18');
/*!40000 ALTER TABLE `persondeed` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER persondeedinsert AFTER INSERT ON PersonDeed FOR EACH ROW
BEGIN
    SET @points = (SELECT points FROM Deed WHERE id = NEW.deed);
    UPDATE Person SET socialScore = socialScore + @points WHERE PESEL = NEW.person;
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` varchar(45) DEFAULT NULL,
  `PESEL` bigint(20) NOT NULL,
  `deed` int(11) NOT NULL,
  `description` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_Report_Person1_idx` (`PESEL`),
  KEY `fk_Report_Deed1_idx` (`deed`),
  CONSTRAINT `fk_Report_Deed1` FOREIGN KEY (`deed`) REFERENCES `deed` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Report_Person1` FOREIGN KEY (`PESEL`) REFERENCES `person` (`PESEL`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report`
--

LOCK TABLES `report` WRITE;
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
/*!40000 ALTER TABLE `report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `login` varchar(100) NOT NULL,
  `password` varchar(100) DEFAULT NULL,
  `salt` varchar(50) DEFAULT NULL,
  `PESEL` bigint(20) DEFAULT NULL,
  `access` enum('1','2','3') DEFAULT NULL,
  PRIMARY KEY (`login`),
  UNIQUE KEY `login_UNIQUE` (`login`),
  KEY `fk_User_Person1_idx` (`PESEL`),
  CONSTRAINT `fk_User_Person1` FOREIGN KEY (`PESEL`) REFERENCES `person` (`PESEL`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES ('empire','69df4f3126666fbf2c3570e0b91841d0','ABCDE',88020703217,'3'),('marek','0aa4d940506eadc58d04421056730f21','4ZYGlAIfwh00',98020703216,'3'),('res','8f79623ce5a5b6eacc6aa8e339a63e24','QSgEZVwBu0Y9',98020703216,'1');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'socialscore'
--
/*!50003 DROP PROCEDURE IF EXISTS `acceptReport` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `acceptReport`(IN repID INT)
BEGIN
    SET autocommit = 0;
    START TRANSACTION;
    SELECT PESEL INTO @pesel FROM Report WHERE id = repID;
    SELECT deed INTO @deed FROM Report WHERE id = repID;
    SELECT date INTO @date FROM Report WHERE id = repID;
    INSERT INTO PersonDeed (person, deed, date) VALUES (@pesel, @deed, STR_TO_DATE(@date, '%Y-%m-%d'));
    DELETE FROM Report WHERE id = repID;
    COMMIT;
END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `auth` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `auth`(IN log varchar(100), IN hash varchar(100))
BEGIN
    DECLARE a INT;
    SET a = (SELECT access FROM user WHERE login = log AND password = hash);
    SELECT IF(a IS NULL, 0, a) AS 'access';
end ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `dismissReport` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
CREATE DEFINER=`root`@`localhost` PROCEDURE `dismissReport`(IN repID INT)
DELETE FROM Report WHERE id = repID ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-01-22 15:02:00
