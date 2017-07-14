/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 5.6.17 : Database - sport
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `device_ms` */

DROP TABLE IF EXISTS `device_ms`;

CREATE TABLE `device_ms` (
  `device_ms_id` int(11) NOT NULL AUTO_INCREMENT,
  `ms_code` char(7) NOT NULL DEFAULT '' COMMENT '主机编码',
  `next_ms_code` char(7) NOT NULL DEFAULT '' COMMENT '下一个设备',
  `last_expire_time` int(11) NOT NULL DEFAULT '0' COMMENT '和上一个设备的有效时间',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '投放使用时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0故障',
  `signal` varchar(30) NOT NULL DEFAULT '' COMMENT '信号强度',
  PRIMARY KEY (`device_ms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `device_ms` */

insert  into `device_ms`(`device_ms_id`,`ms_code`,`next_ms_code`,`last_expire_time`,`agent_id`,`customer_id`,`add_time`,`status`,`signal`) values (1,'0000000','0000001',12,1,1,2147483647,1,''),(3,'0000001','0000002',10,1,1,2147483647,1,''),(4,'0000002','0000000',9,1,1,2147483647,1,'');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
