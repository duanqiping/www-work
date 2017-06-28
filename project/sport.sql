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
/*Table structure for table `ad` */

DROP TABLE IF EXISTS `ad`;

CREATE TABLE `ad` (
  `ad_id` int(11) NOT NULL AUTO_INCREMENT,
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '代理商id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `ad_brand_id` int(11) NOT NULL DEFAULT '0' COMMENT '品牌id',
  `img_url` varchar(50) NOT NULL DEFAULT '' COMMENT '广告图片地址',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '广告标题',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '广告类型',
  `brand_name` varchar(50) NOT NULL DEFAULT '' COMMENT '广告品牌',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `begin_time` int(11) NOT NULL DEFAULT '0' COMMENT '上架时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '下架时间',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0屏蔽 1开启',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `ad` */

insert  into `ad`(`ad_id`,`agent_id`,`customer_id`,`ad_brand_id`,`img_url`,`title`,`type`,`brand_name`,`sort_order`,`begin_time`,`end_time`,`is_show`) values (1,0,0,1,'fasdfij','香飘飘奶茶',1,'香飘飘',1,0,0,1),(2,0,0,0,'','',0,'',0,0,0,1),(3,0,0,0,'','',0,'',0,0,0,1);

/*Table structure for table `ad_brand` */

DROP TABLE IF EXISTS `ad_brand`;

CREATE TABLE `ad_brand` (
  `ad_brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(30) NOT NULL DEFAULT '' COMMENT '广告品牌名',
  `logo_url` varchar(50) NOT NULL DEFAULT '' COMMENT '广告logo地址',
  `ad_addr` varchar(200) NOT NULL DEFAULT '' COMMENT '广告地址',
  `is_show` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0关闭 1显示',
  `ad_mobile` int(11) NOT NULL DEFAULT '0' COMMENT '联系方式',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '广告类型',
  PRIMARY KEY (`ad_brand_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ad_brand` */

insert  into `ad_brand`(`ad_brand_id`,`brand_name`,`logo_url`,`ad_addr`,`is_show`,`ad_mobile`,`type`) values (1,'香飘飘','jioasi ','武汉',0,8888,0);

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `account` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员账号',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '管理员姓名',
  `passwd` char(32) NOT NULL DEFAULT '' COMMENT '管理员密码',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0关闭 1开启',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `last_login_ip` varchar(30) DEFAULT '' COMMENT '最后一次登陆ip',
  `level` tinyint(4) NOT NULL DEFAULT '0' COMMENT '管理员等级',
  `grade` tinyint(4) NOT NULL DEFAULT '1' COMMENT '用户等级',
  `is_audit` tinyint(4) NOT NULL DEFAULT '0' COMMENT '审核状态 0未审核 1已审核',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Data for the table `admin` */

insert  into `admin`(`admin_id`,`account`,`name`,`passwd`,`add_time`,`is_show`,`last_login_time`,`last_login_ip`,`level`,`grade`,`is_audit`,`login_count`) values (1,'17701804871','admin','45569ff57e980b3412ac5a21b7e5bd68',1482894847,1,1498641207,'192.168.0.118',1,1,1,17),(16,'17701804870','test','00b7691d86d96aebd21dd9e138f90840',1498619647,1,0,'',2,1,1,0),(17,'17701804872','test','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(18,'17701804873','test','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(21,'17701804876','test','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,0,0),(24,'17701804879','test9','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(25,'17701804800','test5','00b7691d86d96aebd21dd9e138f90840',1484795647,1,2147483647,'192.168.0.118',2,1,1,1),(26,'17701804801','test5','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(27,'17701804807','test5','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(28,'17701804802','test','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(29,'17701804000','test','00b7691d86d96aebd21dd9e138f90840',1498792447,1,0,'',2,1,1,0);

/*Table structure for table `agent` */

DROP TABLE IF EXISTS `agent`;

CREATE TABLE `agent` (
  `agent_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',
  `account` char(11) NOT NULL DEFAULT '' COMMENT '代理商账号',
  `passwd` char(32) NOT NULL DEFAULT '' COMMENT '代理商密码',
  `grade` tinyint(4) NOT NULL DEFAULT '2' COMMENT '用户等级',
  `rank` tinyint(4) NOT NULL DEFAULT '0' COMMENT '级别',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '归属',
  `agent_address` varchar(200) NOT NULL DEFAULT '' COMMENT '联系地址',
  `agent_mobile` int(11) NOT NULL DEFAULT '0' COMMENT '联系号码',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0关闭 1启用',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `last_login_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后一次登陆ip',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  PRIMARY KEY (`agent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `agent` */

insert  into `agent`(`agent_id`,`name`,`account`,`passwd`,`grade`,`rank`,`parent_id`,`agent_address`,`agent_mobile`,`is_show`,`last_login_time`,`last_login_ip`,`add_time`,`login_count`) values (1,'上海市','111','00b7691d86d96aebd21dd9e138f90840',2,1,0,'上海市、唐镇',2147483647,1,0,'',0,0),(2,'广东省','333','00b7691d86d96aebd21dd9e138f90840',2,1,0,'汕头、xx路',99999,1,0,'',0,0),(3,'深圳市','222','00b7691d86d96aebd21dd9e138f90840',2,2,2,'xx街道xx号',1111110,1,0,'',0,0),(10,'江西省代理','17701804872','00b7691d86d96aebd21dd9e138f90840',2,1,0,'江西路',2147483647,1,0,'',2147483647,0);

/*Table structure for table `code` */

DROP TABLE IF EXISTS `code`;

CREATE TABLE `code` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `mobile` char(11) NOT NULL DEFAULT '' COMMENT '手机号',
  `code` varchar(10) NOT NULL DEFAULT '' COMMENT '验证码',
  `ip` char(15) NOT NULL DEFAULT '' COMMENT 'ip地址',
  `createAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
  `expireAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '时效时间',
  `isUse` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否使用，0\r\n没有使用1使用',
  `usingAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '使用时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6290 DEFAULT CHARSET=utf8;

/*Data for the table `code` */

insert  into `code`(`id`,`mobile`,`code`,`ip`,`createAt`,`expireAt`,`isUse`,`usingAt`) values (6234,'17701804870','3245','','2017-06-20 16:57:51','2017-06-20 18:58:11',1,'0000-00-00 00:00:00'),(6245,'17701804870','0000','192.168.0.115','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(6246,'17701804870','0000','192.168.0.115','2017-06-20 17:55:13','2017-06-20 18:25:13',1,'0000-00-00 00:00:00'),(6247,'18629013794','0000','192.168.0.116','2017-06-20 18:12:45','2017-06-20 18:42:45',1,'0000-00-00 00:00:00'),(6248,'17701804870','0000','192.168.0.115','2017-06-20 20:01:08','2017-06-20 20:31:08',1,'0000-00-00 00:00:00'),(6249,'17701804870','0000','192.168.0.115','2017-06-20 20:32:27','2017-06-20 21:02:27',1,'0000-00-00 00:00:00'),(6250,'17701804870','0000','192.168.0.115','2017-06-20 20:57:22','2017-06-20 21:27:22',1,'0000-00-00 00:00:00'),(6251,'17701804870','0000','192.168.0.115','2017-06-21 09:36:13','2017-06-21 10:06:13',0,'0000-00-00 00:00:00'),(6252,'18629013794','0000','192.168.0.110','2017-06-21 09:51:28','2017-06-21 10:21:28',1,'0000-00-00 00:00:00'),(6253,'18629013794','0000','192.168.0.110','2017-06-21 14:14:01','2017-06-21 14:44:01',1,'0000-00-00 00:00:00'),(6254,'18629013794','0000','192.168.0.110','2017-06-21 14:15:24','2017-06-21 14:45:24',1,'0000-00-00 00:00:00'),(6255,'13133333333','0000','192.168.0.110','2017-06-21 14:18:30','2017-06-21 14:48:30',0,'0000-00-00 00:00:00'),(6256,'13111111111','0000','192.168.0.110','2017-06-21 14:37:03','2017-06-21 15:07:03',0,'0000-00-00 00:00:00'),(6257,'17701804872','0000','192.168.0.115','2017-06-21 15:14:24','2017-06-21 15:44:24',0,'0000-00-00 00:00:00'),(6258,'17701804875','0000','192.168.0.115','2017-06-21 15:15:56','2017-06-21 15:45:56',1,'0000-00-00 00:00:00'),(6259,'18611111111','0000','192.168.0.110','2017-06-21 15:25:45','2017-06-21 15:55:45',1,'0000-00-00 00:00:00'),(6260,'18611111111','0000','192.168.0.110','2017-06-21 15:26:57','2017-06-21 15:56:57',0,'0000-00-00 00:00:00'),(6261,'17701804876','0000','192.168.0.115','2017-06-21 15:47:10','2017-06-21 16:17:10',0,'0000-00-00 00:00:00'),(6262,'18600000000','0000','192.168.0.110','2017-06-21 15:54:21','2017-06-21 16:24:21',1,'0000-00-00 00:00:00'),(6263,'18600000000','0000','192.168.0.110','2017-06-21 15:55:21','2017-06-21 16:25:21',1,'0000-00-00 00:00:00'),(6264,'18600000000','0000','192.168.0.110','2017-06-21 16:05:27','2017-06-21 16:35:27',1,'0000-00-00 00:00:00'),(6265,'18600000000','0000','192.168.0.110','2017-06-21 16:06:27','2017-06-21 16:36:27',1,'0000-00-00 00:00:00'),(6266,'17701804877','0000','192.168.0.115','2017-06-21 16:11:49','2017-06-21 16:41:49',1,'0000-00-00 00:00:00'),(6267,'17701804877','0000','192.168.0.115','2017-06-21 16:12:54','2017-06-21 16:42:54',1,'0000-00-00 00:00:00'),(6268,'17701804877','0000','192.168.0.115','2017-06-21 16:12:57','2017-06-21 16:42:57',1,'0000-00-00 00:00:00'),(6269,'18600000000','0000','192.168.0.110','2017-06-21 16:14:01','2017-06-21 16:44:01',1,'0000-00-00 00:00:00'),(6270,'17701804877','0000','192.168.0.115','2017-06-21 16:18:15','2017-06-21 16:48:15',1,'0000-00-00 00:00:00'),(6271,'17701804877','0000','192.168.0.115','2017-06-21 16:18:19','2017-06-21 16:48:19',0,'0000-00-00 00:00:00'),(6272,'18600000000','0000','192.168.0.110','2017-06-21 16:18:29','2017-06-21 16:48:29',1,'0000-00-00 00:00:00'),(6273,'18600000000','0000','192.168.0.110','2017-06-21 16:22:03','2017-06-21 16:52:03',1,'0000-00-00 00:00:00'),(6274,'18629013794','0000','192.168.0.110','2017-06-21 16:45:25','2017-06-21 17:15:25',0,'0000-00-00 00:00:00'),(6275,'18600000000','0000','192.168.0.110','2017-06-21 16:48:11','2017-06-21 17:18:11',1,'0000-00-00 00:00:00'),(6276,'18600000000','0000','192.168.0.110','2017-06-21 16:49:24','2017-06-21 17:19:24',1,'0000-00-00 00:00:00'),(6277,'18600000000','0000','192.168.0.110','2017-06-21 16:54:02','2017-06-21 17:24:02',1,'0000-00-00 00:00:00'),(6278,'18600000000','0000','192.168.0.110','2017-06-21 17:05:09','2017-06-21 17:35:09',1,'0000-00-00 00:00:00'),(6279,'18600000000','0000','192.168.0.110','2017-06-21 17:06:58','2017-06-21 17:36:58',1,'0000-00-00 00:00:00'),(6280,'18600000000','0000','192.168.0.110','2017-06-21 17:13:45','2017-06-21 17:43:45',0,'0000-00-00 00:00:00'),(6281,'18600000001','0000','192.168.0.110','2017-06-21 17:14:38','2017-06-21 17:44:38',0,'0000-00-00 00:00:00'),(6282,'18600000002','0000','192.168.0.110','2017-06-21 17:42:33','2017-06-21 18:12:33',1,'0000-00-00 00:00:00'),(6283,'18600000002','0000','192.168.0.110','2017-06-21 17:46:41','2017-06-21 18:16:41',0,'0000-00-00 00:00:00'),(6284,'18600000003','0000','192.168.0.106','2017-06-23 18:35:11','2017-06-23 19:05:11',1,'0000-00-00 00:00:00'),(6285,'18600000003','0000','192.168.0.107','2017-06-26 10:55:51','2017-06-26 11:25:51',0,'0000-00-00 00:00:00'),(6286,'18600000009','0000','192.168.0.107','2017-06-27 09:40:17','2017-06-27 10:10:17',1,'0000-00-00 00:00:00'),(6287,'18600000009','0000','192.168.0.107','2017-06-27 09:42:37','2017-06-27 10:12:37',0,'0000-00-00 00:00:00'),(6288,'17701804875','0000','192.168.0.118','2017-06-27 09:51:24','2017-06-27 10:21:24',0,'0000-00-00 00:00:00'),(6289,'17701804878','0000','192.168.0.118','2017-06-27 09:57:54','2017-06-27 10:27:54',0,'0000-00-00 00:00:00');

/*Table structure for table `customer` */

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `customer_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` char(6) NOT NULL DEFAULT '0' COMMENT '系统生成唯一编码',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '客户名称',
  `account` char(11) NOT NULL DEFAULT '' COMMENT '客户账号',
  `passwd` char(32) NOT NULL DEFAULT '' COMMENT '客户密码',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户归属',
  `customer_addr` varchar(200) NOT NULL DEFAULT '' COMMENT '地址',
  `customer_mobile` int(11) NOT NULL DEFAULT '0' COMMENT '联系号码',
  `device_num` int(11) NOT NULL DEFAULT '0' COMMENT '设备数量',
  `grade` tinyint(4) NOT NULL DEFAULT '3' COMMENT '用户级别',
  `score_table` varchar(30) NOT NULL DEFAULT '' COMMENT '对应成绩表',
  `rank_y_table` varchar(30) NOT NULL DEFAULT '' COMMENT '年成绩排行表',
  `rank_m_table` varchar(30) NOT NULL DEFAULT '' COMMENT '月成绩排行榜',
  `rank_w_table` varchar(30) NOT NULL DEFAULT '' COMMENT '周成绩排行榜',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1跑步 2骑行',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0屏蔽 1开启',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `last_login_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后一次登陆ip',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `customer` */

insert  into `customer`(`customer_id`,`code`,`name`,`account`,`passwd`,`agent_id`,`customer_addr`,`customer_mobile`,`device_num`,`grade`,`score_table`,`rank_y_table`,`rank_m_table`,`rank_w_table`,`type`,`is_show`,`add_time`,`last_login_time`,`last_login_ip`,`login_count`) values (14,'03947','杭州大学','17701800004','00b7691d86d96aebd21dd9e138f90840',1,'杭州市中心',0,3,3,'score_03947','rank_y_03947','rank_m_03947','rank_w_03947',1,1,1498641422,0,'',0);

/*Table structure for table `device` */

DROP TABLE IF EXISTS `device`;

CREATE TABLE `device` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT,
  `wb_code` varchar(50) NOT NULL DEFAULT '' COMMENT '手环编码',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`device_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `device` */

insert  into `device`(`device_id`,`wb_code`,`user_id`) values (1,'131243',1);

/*Table structure for table `device_ms` */

DROP TABLE IF EXISTS `device_ms`;

CREATE TABLE `device_ms` (
  `device_ms_id` int(11) NOT NULL AUTO_INCREMENT,
  `ms_code` varchar(50) NOT NULL DEFAULT '' COMMENT '主机编码',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '投放时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0故障',
  `detail` varchar(500) NOT NULL DEFAULT '' COMMENT '设备详细信息',
  PRIMARY KEY (`device_ms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `device_ms` */

insert  into `device_ms`(`device_ms_id`,`ms_code`,`agent_id`,`customer_id`,`time`,`status`,`detail`) values (1,'1120',1,1,2147483647,1,'{\"1\":{\"expire_time\":60,\"target\":2},\"2\":{\"expire_time\":80,\"target\":3},\"3\":{\"expire_time\":100,\"target\":1}}'),(2,'',0,0,0,1,'');

/*Table structure for table `rank_m_03947` */

DROP TABLE IF EXISTS `rank_m_03947`;

CREATE TABLE `rank_m_03947` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `rank_m_03947` */

insert  into `rank_m_03947`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`) values (4,111,14,30,1,1231548,1498655418);

/*Table structure for table `rank_w_03947` */

DROP TABLE IF EXISTS `rank_w_03947`;

CREATE TABLE `rank_w_03947` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `rank_w_03947` */

insert  into `rank_w_03947`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`) values (7,111,14,30,1,1231548,1498308675),(8,111,14,34,1,1231548,1498395075);

/*Table structure for table `rank_y_03947` */

DROP TABLE IF EXISTS `rank_y_03947`;

CREATE TABLE `rank_y_03947` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `rank_y_03947` */

insert  into `rank_y_03947`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`) values (8,111,14,30,1,1231548,1498655418);

/*Table structure for table `score_03947` */

DROP TABLE IF EXISTS `score_03947`;

CREATE TABLE `score_03947` (
  `score_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `begin_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '比赛耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '跑步长度',
  `cycles` int(11) NOT NULL DEFAULT '0' COMMENT '比赛圈数',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `mode` tinyint(4) NOT NULL DEFAULT '0' COMMENT '成绩类型：1训练 2考试 3比赛',
  PRIMARY KEY (`score_id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

/*Data for the table `score_03947` */

insert  into `score_03947`(`score_id`,`user_id`,`begin_time`,`end_time`,`time`,`add_time`,`length`,`cycles`,`customer_id`,`mode`) values (1,111,123256,123456,1231548,0,100,5,14,1),(2,111,123256,123456,1231548,0,100,1,14,1),(3,111,123256,123456,1231548,0,100,1,14,1),(4,111,123256,123456,1231548,0,100,1,14,1),(5,111,123256,123456,1231548,0,100,1,14,1),(6,111,123256,123456,1231548,0,100,1,14,1),(7,111,123256,123456,1231548,0,100,1,14,1),(8,111,123256,123456,1231548,0,100,1,14,1),(9,111,123256,123456,1231548,0,100,1,14,1),(10,111,123256,123456,1231548,0,100,1,14,1),(11,111,123256,123456,1231548,0,100,1,14,1),(12,111,123256,123456,1231548,0,100,1,14,1),(13,111,123256,123456,1231548,0,100,1,14,1),(14,111,123256,123456,1231548,0,100,1,14,1),(15,111,123256,123456,1231548,0,100,1,14,1),(16,111,123256,123456,1231548,0,100,1,14,1),(17,111,123256,123456,1231548,0,100,1,14,1),(18,111,123256,123456,1231548,0,100,1,14,1),(19,111,123256,123456,1231548,0,100,1,14,1),(20,111,123256,123456,1231548,0,100,1,14,1),(21,111,123256,123456,1231548,0,100,1,14,1),(22,111,123256,123456,1231548,0,100,1,14,1),(23,111,123256,123456,1231548,0,100,1,14,1),(24,111,123256,123456,1231548,0,100,1,14,1),(25,111,123256,123456,1231548,0,100,1,14,1),(26,111,123256,123456,1231548,0,100,1,14,1),(27,111,123256,123456,1231548,0,100,1,14,1),(28,111,123256,123456,1231548,0,100,1,14,1),(29,111,123256,123456,1231548,0,100,1,14,1),(30,111,123256,123456,1231548,0,100,1,14,1),(31,111,123256,123456,1231548,0,100,1,14,1),(32,111,123256,123456,1231548,0,100,1,14,1),(33,111,123256,123456,1231548,0,100,1,14,1),(34,111,123256,123456,1231548,0,100,1,14,1),(35,111,123256,123456,1231548,0,100,1,14,1);

/*Table structure for table `teacher` */

DROP TABLE IF EXISTS `teacher`;

CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '老师名',
  `account` char(11) NOT NULL DEFAULT '0' COMMENT '老师账号',
  `passwd` char(32) NOT NULL DEFAULT '' COMMENT '老师密码',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1开启 0屏蔽',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `last_login_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后一次登陆ip',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `grade` tinyint(4) NOT NULL DEFAULT '4' COMMENT '用户级别',
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `teacher` */

insert  into `teacher`(`teacher_id`,`customer_id`,`name`,`account`,`passwd`,`add_time`,`is_show`,`last_login_time`,`last_login_ip`,`login_count`,`grade`) values (1,1,'王波','111222','00b7691d86d96aebd21dd9e138f90840',0,1,2147483647,'192.168.0.118',3,4),(2,0,'王老师','17701800004','00b7691d86d96aebd21dd9e138f90840',1498554052,1,0,'',0,4),(3,1,'王老师','17701800005','00b7691d86d96aebd21dd9e138f90840',1498554085,1,0,'',0,4);

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `is_check` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1合法 2非法',
  `account` char(11) NOT NULL DEFAULT '0' COMMENT '手机号',
  `passwd` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nick` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `img` varchar(100) NOT NULL DEFAULT '' COMMENT '头像路径',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `qq` int(11) NOT NULL DEFAULT '0' COMMENT 'qq号',
  `weixin` varchar(50) NOT NULL DEFAULT '' COMMENT '微信号',
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '性别 1男 2女',
  `height` tinyint(4) NOT NULL DEFAULT '0' COMMENT '身高',
  `weight` tinyint(4) NOT NULL DEFAULT '0' COMMENT '体重',
  `register_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `school` varchar(30) NOT NULL DEFAULT '' COMMENT '学校',
  `school_num` int(11) NOT NULL DEFAULT '0' COMMENT '学校编号',
  `dept` varchar(30) NOT NULL DEFAULT '' COMMENT '系别',
  `class` varchar(30) NOT NULL DEFAULT '' COMMENT '班级',
  `studentId` int(11) NOT NULL DEFAULT '0' COMMENT '学号',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1学生 2体育爱好者',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `last_login_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后一次登陆ip',
  `login_count` int(11) DEFAULT '0' COMMENT '登陆次数',
  PRIMARY KEY (`user_id`,`nick`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`user_id`,`is_check`,`account`,`passwd`,`nick`,`img`,`email`,`qq`,`weixin`,`sex`,`height`,`weight`,`register_time`,`school`,`school_num`,`dept`,`class`,`studentId`,`type`,`customer_id`,`last_login_time`,`last_login_ip`,`login_count`) values (1,1,'17701804871','e10adc3949ba59abbe56e057f20f883e','齐平','','pksanwei@163.com',827068977,'fiosah',1,0,0,0,'',0,'','',0,0,0,2147483647,'192.168.0.118',1),(14,1,'17701804876','00b7691d86d96aebd21dd9e138f90840','段齐平22','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,0,'',0),(15,1,'18600000000','4297f44b13955235245b2497399d7a93','18600000000','public/guest/upload/photo/18600000000/18600000000head.jpg','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,1498643399,'192.168.0.100',5),(16,1,'18600000001','e10adc3949ba59abbe56e057f20f883e','18600000001','','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,0,'',0),(17,1,'18600000003','4297f44b13955235245b2497399d7a93','18600000003','public/guest/upload/photo/18600000003/18600000003head.jpg','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,1498643147,'192.168.0.100',6),(18,1,'17701804875','00b7691d86d96aebd21dd9e138f90840','17701804875','public/guest/upload/photo/17701804875/17701804875head.png','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,0,'',0),(19,1,'17701804878','00b7691d86d96aebd21dd9e138f90840','17701804878','public/guest/upload/photo/17701804878/17701804878head.png','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,2147483647,'192.168.0.118',2);

/*Table structure for table `user_online` */

DROP TABLE IF EXISTS `user_online`;

CREATE TABLE `user_online` (
  `online_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) NOT NULL DEFAULT '0',
  `addr` varchar(50) NOT NULL DEFAULT '' COMMENT '登录地址',
  `active_time` int(20) NOT NULL DEFAULT '0' COMMENT '最后一次登录时间',
  PRIMARY KEY (`online_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

/*Data for the table `user_online` */

insert  into `user_online`(`online_id`,`user_id`,`addr`,`active_time`) values (1,4,'192.168.0.115',1498011996),(2,7,'192.168.0.115',1498013119),(3,8,'192.168.0.115',1498013573),(4,9,'192.168.0.115',1498029502),(6,14,'192.168.0.115',1498530905),(7,15,'192.168.0.115',1498528836),(8,16,'192.168.0.115',1498036486),(10,1,'192.168.0.108',1498538929),(11,17,'192.168.0.118',1498528821),(12,18,'192.168.0.118',1498528592),(13,19,'192.168.0.118',1498538783);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
