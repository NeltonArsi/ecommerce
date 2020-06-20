DROP TABLE IF EXISTS `tb_persons`;

DROP TABLE IF EXISTS `tb_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tb_users` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `desperson` varchar(64) NOT NULL,
  `desemail` varchar(128) DEFAULT NULL,
  `deslogin` varchar(64) NOT NULL,
  `despassword` varchar(256) NOT NULL,
  `inadmin` tinyint(4) NOT NULL DEFAULT 0,
  `nrphone` bigint(20) DEFAULT NULL,
  `dtregister` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`iduser`),
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `tb_users` WRITE;
/*!40000 ALTER TABLE `tb_users` DISABLE KEYS */;
INSERT INTO `tb_users` VALUES (1,'Administrador','neltonsilva13@gmail.com','admin','$2y$12$BwVG0yYZ0vrnrK3no1RkmOhZizksanWpAFWrS9KcoCuPL5WC7sNIu',1,31988630130,'2020-06-16 02:40:13'),(2,'Nelton Silva','neltonarsi@gmail.com','nelton','$2y$12$o160f6DH3Qt4bQbPDGDz9un3Elp3BiOmsTeBLag8VqCcnPp2Tu3B2',1,31988630130,'2020-06-03 01:08:32'),(3,'Suporte','suporte@hcode.com.br','suporte','$2y$12$OSgYUDAZhLFc6OYjKe0xAOzilXDfU8LsH5jhiq42mTwm3NGr4Zupe',1,1112345678,'2017-03-15 16:10:27'),(4,'Erika Silva','neltonarsilva@gmail.com','erika','$2y$12$qSrBSrJZs44v.yuhLjH1PeiGo5rJ.5S1w4JAiQuFY6zDifdGMPw.6',0,31988150172,'2020-06-16 03:24:05'),(5,'Nilton Cesar','neltonarsi@hotmail.com','neltonarsi@hotmail.com','$2y$12$uBBWkHsN0HBMWGxChpiwKOiDQqcAdbt0nhQdiSlDjmxcsPMd07aJy',0,31988630130,'2020-06-09 19:07:09'),(6,'Filipe Bispo','nelton@masterpublica.com.br','filipe','123',1,31988630130,'2020-06-18 16:09:50');
/*!40000 ALTER TABLE `tb_users` ENABLE KEYS */;
UNLOCK TABLES;