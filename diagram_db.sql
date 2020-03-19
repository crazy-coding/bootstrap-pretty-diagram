# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.25)
# Database: diagram_db
# Generation Time: 2019-09-04 06:41:09 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table flows_new
# ------------------------------------------------------------

DROP TABLE IF EXISTS `flows_new`;

CREATE TABLE `flows_new` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userID` int(11) unsigned NOT NULL,
  `campaignID` int(11) NOT NULL,
  `flowID` int(11) unsigned NOT NULL,
  `flowOrder` int(11) unsigned NOT NULL,
  `object_type` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `value` text,
  `value_detail` text,
  `delay` float NOT NULL DEFAULT '0',
  `delay_value` varchar(255) DEFAULT NULL,
  `pos_x` varchar(100) DEFAULT NULL,
  `pos_y` varchar(100) DEFAULT NULL,
  `parent_cam` int(11) unsigned NOT NULL DEFAULT '0',
  `path_str` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `flows_new` WRITE;
/*!40000 ALTER TABLE `flows_new` DISABLE KEYS */;

INSERT INTO `flows_new` (`id`, `userID`, `campaignID`, `flowID`, `flowOrder`, `object_type`, `title`, `value`, `value_detail`, `delay`, `delay_value`, `pos_x`, `pos_y`, `parent_cam`, `path_str`)
VALUES
	(37,1,1,1,1,'start','Start','Add_To_List','Master_Abandon_Cart',2,'hour','100px','0px',0,''),
	(38,1,1,1,2,'message','Initiate','We noticed you didn’t complete your purchase, anything we can to help? [trackinglink]','',3,'hour','174px','102px',1,'Yes'),
	(39,1,1,1,3,'condition','123213123','Conversion_Happened','4|5',20,'hour','352px','171px',2,''),
	(40,1,1,1,4,'message','sdfdsfsd','31232121123','',2,'hour','488px','45px',3,'Yes'),
	(41,1,1,1,5,'message','12312','3213','',3,'hour','593px','167px',3,'No'),
	(42,1,1,1,6,'condition','12321','Conversion_Happened','7|8',0,'hour','846px','137px',5,''),
	(43,1,1,1,7,'message','12312','12312','',0,'hour','777px','241px',6,'Yes'),
	(44,1,1,1,8,'message','23423','4234','',0,'hour','1019px','217px',6,'No'),
	(45,1,1,1,9,'message','1231231','2321','',3,'hour','488px','259px',3,'');

/*!40000 ALTER TABLE `flows_new` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
