# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.7.25)
# Database: gojs_db
# Generation Time: 2019-08-20 01:26:38 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table gojs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gojs`;

CREATE TABLE `gojs` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `position` varchar(255) DEFAULT NULL,
  `yes` varchar(255) DEFAULT NULL,
  `no` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT '',
  `date` datetime DEFAULT '2000-01-02 00:00:00',
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `gojs` WRITE;
/*!40000 ALTER TABLE `gojs` DISABLE KEYS */;

INSERT INTO `gojs` (`id`, `userid`, `position`, `yes`, `no`, `url`, `date`, `data`)
VALUES
	(153,1,'visit web','go to upsell','go to credit','https://visitor.com','2019-08-20 01:25:35','{ &quot;class&quot;: &quot;GraphLinksModel&quot;,\n  &quot;linkFromPortIdProperty&quot;: &quot;fromPort&quot;,\n  &quot;linkToPortIdProperty&quot;: &quot;toPort&quot;,\n  &quot;nodeDataArray&quot;: [ \n{&quot;key&quot;:0, &quot;loc&quot;:&quot;-6 118.99999999999993&quot;, &quot;text&quot;:&quot;Go to credit card page&quot;},\n{&quot;category&quot;:&quot;Conditional&quot;, &quot;text&quot;:&quot;Visitor Check&quot;, &quot;key&quot;:-3, &quot;loc&quot;:&quot;-4.710937499999979 -37.316406249999986&quot;},\n{&quot;text&quot;:&quot;Go to upsell and discount page&quot;, &quot;key&quot;:-6, &quot;loc&quot;:&quot;177.5 118.13671875000004&quot;}\n ],\n  &quot;linkDataArray&quot;: [ \n{&quot;from&quot;:-3, &quot;to&quot;:-6, &quot;fromPort&quot;:&quot;B&quot;, &quot;toPort&quot;:&quot;T&quot;, &quot;visible&quot;:true, &quot;text&quot;:&quot;Yes&quot;, &quot;points&quot;:[-4.710937499999972,8.559042358398457,-4.710937499999972,18.559042358398457,-4.710937499999972,45.410156250000036,151.6935043334961,45.410156250000036,151.6935043334961,72.26127014160161,151.6935043334961,82.26127014160161]},\n{&quot;from&quot;:-3, &quot;to&quot;:0, &quot;fromPort&quot;:&quot;R&quot;, &quot;toPort&quot;:&quot;T&quot;, &quot;visible&quot;:true, &quot;text&quot;:&quot;No&quot;, &quot;points&quot;:[118.72499084472659,-37.31640624999998,128.7249908447266,-37.31640624999998,128.7249908447266,48.81065902709958,-6,48.81065902709958,-6,81.06227569580071,-6,91.06227569580071]}\n ]}'),
	(154,1,'go to upsell','','','https://upsell.com','2019-08-20 01:25:35','{ &quot;class&quot;: &quot;GraphLinksModel&quot;,\n  &quot;linkFromPortIdProperty&quot;: &quot;fromPort&quot;,\n  &quot;linkToPortIdProperty&quot;: &quot;toPort&quot;,\n  &quot;nodeDataArray&quot;: [ \n{&quot;key&quot;:0, &quot;loc&quot;:&quot;-6 118.99999999999993&quot;, &quot;text&quot;:&quot;Go to credit card page&quot;},\n{&quot;category&quot;:&quot;Conditional&quot;, &quot;text&quot;:&quot;Visitor Check&quot;, &quot;key&quot;:-3, &quot;loc&quot;:&quot;-4.710937499999979 -37.316406249999986&quot;},\n{&quot;text&quot;:&quot;Go to upsell and discount page&quot;, &quot;key&quot;:-6, &quot;loc&quot;:&quot;177.5 118.13671875000004&quot;}\n ],\n  &quot;linkDataArray&quot;: [ \n{&quot;from&quot;:-3, &quot;to&quot;:-6, &quot;fromPort&quot;:&quot;B&quot;, &quot;toPort&quot;:&quot;T&quot;, &quot;visible&quot;:true, &quot;text&quot;:&quot;Yes&quot;, &quot;points&quot;:[-4.710937499999972,8.559042358398457,-4.710937499999972,18.559042358398457,-4.710937499999972,45.410156250000036,151.6935043334961,45.410156250000036,151.6935043334961,72.26127014160161,151.6935043334961,82.26127014160161]},\n{&quot;from&quot;:-3, &quot;to&quot;:0, &quot;fromPort&quot;:&quot;R&quot;, &quot;toPort&quot;:&quot;T&quot;, &quot;visible&quot;:true, &quot;text&quot;:&quot;No&quot;, &quot;points&quot;:[118.72499084472659,-37.31640624999998,128.7249908447266,-37.31640624999998,128.7249908447266,48.81065902709958,-6,48.81065902709958,-6,81.06227569580071,-6,91.06227569580071]}\n ]}'),
	(155,1,'go to credit','','','https://checkout.com','2019-08-20 01:25:35','{ &quot;class&quot;: &quot;GraphLinksModel&quot;,\n  &quot;linkFromPortIdProperty&quot;: &quot;fromPort&quot;,\n  &quot;linkToPortIdProperty&quot;: &quot;toPort&quot;,\n  &quot;nodeDataArray&quot;: [ \n{&quot;key&quot;:0, &quot;loc&quot;:&quot;-6 118.99999999999993&quot;, &quot;text&quot;:&quot;Go to credit card page&quot;},\n{&quot;category&quot;:&quot;Conditional&quot;, &quot;text&quot;:&quot;Visitor Check&quot;, &quot;key&quot;:-3, &quot;loc&quot;:&quot;-4.710937499999979 -37.316406249999986&quot;},\n{&quot;text&quot;:&quot;Go to upsell and discount page&quot;, &quot;key&quot;:-6, &quot;loc&quot;:&quot;177.5 118.13671875000004&quot;}\n ],\n  &quot;linkDataArray&quot;: [ \n{&quot;from&quot;:-3, &quot;to&quot;:-6, &quot;fromPort&quot;:&quot;B&quot;, &quot;toPort&quot;:&quot;T&quot;, &quot;visible&quot;:true, &quot;text&quot;:&quot;Yes&quot;, &quot;points&quot;:[-4.710937499999972,8.559042358398457,-4.710937499999972,18.559042358398457,-4.710937499999972,45.410156250000036,151.6935043334961,45.410156250000036,151.6935043334961,72.26127014160161,151.6935043334961,82.26127014160161]},\n{&quot;from&quot;:-3, &quot;to&quot;:0, &quot;fromPort&quot;:&quot;R&quot;, &quot;toPort&quot;:&quot;T&quot;, &quot;visible&quot;:true, &quot;text&quot;:&quot;No&quot;, &quot;points&quot;:[118.72499084472659,-37.31640624999998,128.7249908447266,-37.31640624999998,128.7249908447266,48.81065902709958,-6,48.81065902709958,-6,81.06227569580071,-6,91.06227569580071]}\n ]}');

/*!40000 ALTER TABLE `gojs` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
