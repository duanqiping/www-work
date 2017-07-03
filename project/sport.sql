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
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

/*Data for the table `admin` */

insert  into `admin`(`admin_id`,`account`,`name`,`passwd`,`add_time`,`is_show`,`last_login_time`,`last_login_ip`,`level`,`grade`,`is_audit`,`login_count`) values (1,'17701804871','admin','45569ff57e980b3412ac5a21b7e5bd68',1482894847,1,1498802926,'192.168.0.118',1,1,1,21),(16,'17701804870','test','00b7691d86d96aebd21dd9e138f90840',1498619647,1,0,'',2,1,1,0),(17,'17701804872','test','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(18,'17701804873','test','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(21,'17701804876','test','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,0,0),(24,'17701804879','test9','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(25,'17701804800','test5','00b7691d86d96aebd21dd9e138f90840',1484795647,1,2147483647,'192.168.0.118',2,1,1,1),(26,'17701804801','test5','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(27,'17701804807','test5','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(28,'17701804802','test','00b7691d86d96aebd21dd9e138f90840',1484795647,0,0,'',2,1,1,0),(29,'17701804000','test','00b7691d86d96aebd21dd9e138f90840',1498792447,1,0,'',2,1,1,0),(30,'17701804878','管理员','00b7691d86d96aebd21dd9e138f90840',1498801032,1,1498801067,'192.168.0.118',2,1,1,1),(31,'17701804880','管理员2','00b7691d86d96aebd21dd9e138f90840',1498801088,1,0,'',2,1,1,0),(32,'','','',0,1,0,'',0,1,0,0);

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
  `length` int(11) NOT NULL DEFAULT '400' COMMENT '跑道长度',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0屏蔽 1开启',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `last_login_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后一次登陆ip',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `longitude_y` varchar(50) NOT NULL DEFAULT '' COMMENT '经度',
  `latitude_x` varchar(50) NOT NULL DEFAULT '' COMMENT '维度',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

/*Data for the table `customer` */

insert  into `customer`(`customer_id`,`code`,`name`,`account`,`passwd`,`agent_id`,`customer_addr`,`customer_mobile`,`device_num`,`grade`,`score_table`,`rank_y_table`,`rank_m_table`,`rank_w_table`,`type`,`length`,`is_show`,`add_time`,`last_login_time`,`last_login_ip`,`login_count`,`longitude_y`,`latitude_x`) values (25,'42001','上海交通大学','17701800000','00b7691d86d96aebd21dd9e138f90840',1,'上海市',0,1,3,'z_score_42001','z_rank_y_42001','z_rank_m_42001','z_rank_w_42001',1,400,1,1498737342,0,'',0,'121.4451735741','31.0292955073'),(26,'38596','华东师范大学','17701800001','00b7691d86d96aebd21dd9e138f90840',1,'上海市',0,1,3,'z_score_38596','z_rank_y_38596','z_rank_m_38596','z_rank_w_38596',1,200,1,1498737428,0,'',0,'121.4130756826','31.2327466049'),(27,'64113','上海师范大学','17701800002','00b7691d86d96aebd21dd9e138f90840',1,'上海市',0,1,3,'z_score_64113','z_rank_y_64113','z_rank_m_64113','z_rank_w_64113',1,400,1,1498737534,0,'',0,'121.4231968672','31.1675712034'),(28,'09182','上海科技大学','17701800003','00b7691d86d96aebd21dd9e138f90840',1,'上海市',0,1,3,'z_score_09182','z_rank_y_09182','z_rank_m_09182','z_rank_w_09182',1,800,1,1498802288,0,'',0,'121.5983467890','31.1847018865'),(30,'19738','上海科技大学2','17701800004','00b7691d86d96aebd21dd9e138f90840',1,'上海市',0,1,3,'z_score_19738','z_rank_y_19738','z_rank_m_19738','z_rank_w_19738',1,400,1,1498826394,0,'',0,'121.5983467890','31.1847018865');

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

/*Table structure for table `rank_marathon` */

DROP TABLE IF EXISTS `rank_marathon`;

CREATE TABLE `rank_marathon` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '长度',
  PRIMARY KEY (`rank_id`),
  KEY `user_id` (`user_id`),
  KEY `customer_id` (`customer_id`),
  KEY `score_id` (`score_id`),
  KEY `cycles` (`cycles`),
  KEY `time` (`time`),
  KEY `add_time` (`add_time`),
  KEY `length` (`length`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

/*Data for the table `rank_marathon` */

insert  into `rank_marathon`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`,`length`) values (3,15,30,23,26,500,1498874744,4000),(4,15,30,27,52,700,1498874835,5600),(5,15,30,42,105,200,1498875364,11600);

/*Table structure for table `rank_singe` */

DROP TABLE IF EXISTS `rank_singe`;

CREATE TABLE `rank_singe` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '长度',
  PRIMARY KEY (`rank_id`),
  KEY `user_id` (`user_id`),
  KEY `customer_id` (`customer_id`),
  KEY `score_id` (`score_id`),
  KEY `time` (`time`),
  KEY `add_time` (`add_time`),
  KEY `length` (`length`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

/*Data for the table `rank_singe` */

insert  into `rank_singe`(`rank_id`,`user_id`,`customer_id`,`score_id`,`time`,`add_time`,`length`) values (5,14,30,86,17,1498888549,400),(6,13,30,109,1,1498889828,400),(7,12,30,111,12,1498889823,400);

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
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '累计长度',
  PRIMARY KEY (`user_id`,`nick`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`user_id`,`is_check`,`account`,`passwd`,`nick`,`img`,`email`,`qq`,`weixin`,`sex`,`height`,`weight`,`register_time`,`school`,`school_num`,`dept`,`class`,`studentId`,`type`,`customer_id`,`last_login_time`,`last_login_ip`,`login_count`,`length`) values (1,1,'17701804871','e10adc3949ba59abbe56e057f20f883e','齐平','','pksanwei@163.com',827068977,'fiosah',1,0,0,0,'',0,'','',0,0,0,2147483647,'192.168.0.118',1,0),(14,1,'17701804876','00b7691d86d96aebd21dd9e138f90840','段齐平22','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,0,'',0,8000),(15,1,'18600000000','4297f44b13955235245b2497399d7a93','18600000000','public/guest/upload/photo/18600000000/18600000000head.jpg','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,1498804304,'192.168.0.110',89,10400),(16,1,'18600000001','e10adc3949ba59abbe56e057f20f883e','18600000001','','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,0,'',0,0),(17,1,'18600000003','4297f44b13955235245b2497399d7a93','18600000003','public/guest/upload/photo/18600000003/18600000003head.jpg','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,1498705190,'192.168.0.106',8,0),(18,1,'17701804875','00b7691d86d96aebd21dd9e138f90840','17701804875','public/guest/upload/photo/17701804875/17701804875head.png','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,0,'',0,0),(19,1,'17701804878','00b7691d86d96aebd21dd9e138f90840','17701804878','public/guest/upload/photo/17701804878/17701804878head.png','',0,'',1,0,0,2147483647,'',0,'','',0,0,0,2147483647,'192.168.0.118',2,0);

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

/*Table structure for table `z_rank_m_09182` */

DROP TABLE IF EXISTS `z_rank_m_09182`;

CREATE TABLE `z_rank_m_09182` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '长度',
  PRIMARY KEY (`rank_id`),
  KEY `user_id` (`user_id`),
  KEY `customer_id` (`customer_id`),
  KEY `score_id` (`score_id`),
  KEY `cycles` (`cycles`),
  KEY `time` (`time`),
  KEY `add_time` (`add_time`),
  KEY `length` (`length`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_m_09182` */

/*Table structure for table `z_rank_m_19738` */

DROP TABLE IF EXISTS `z_rank_m_19738`;

CREATE TABLE `z_rank_m_19738` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '长度',
  PRIMARY KEY (`rank_id`),
  KEY `user_id` (`user_id`),
  KEY `customer_id` (`customer_id`),
  KEY `score_id` (`score_id`),
  KEY `cycles` (`cycles`),
  KEY `time` (`time`),
  KEY `add_time` (`add_time`),
  KEY `length` (`length`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_m_19738` */

insert  into `z_rank_m_19738`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`,`length`) values (41,13,30,89,1,17,1498701806,400),(42,13,30,90,2,2,1498890041,800),(43,13,30,149,3,9,1498890143,1200),(46,14,30,110,3,1,1498891314,400);

/*Table structure for table `z_rank_m_38596` */

DROP TABLE IF EXISTS `z_rank_m_38596`;

CREATE TABLE `z_rank_m_38596` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_m_38596` */

/*Table structure for table `z_rank_m_42001` */

DROP TABLE IF EXISTS `z_rank_m_42001`;

CREATE TABLE `z_rank_m_42001` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_m_42001` */

insert  into `z_rank_m_42001`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`) values (1,1,25,1,1,200,1498738085),(2,1,25,3,2,420,1498738140),(3,1,25,4,3,666,1498738145),(4,1,25,5,4,1099,1498738152),(5,1,25,6,5,2000,1498738170),(6,15,25,7,1,20,1498738226),(7,15,25,8,2,55,1498738230),(8,15,25,9,3,200,1498738243),(9,15,25,10,4,290,1498738248);

/*Table structure for table `z_rank_m_64113` */

DROP TABLE IF EXISTS `z_rank_m_64113`;

CREATE TABLE `z_rank_m_64113` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_m_64113` */

/*Table structure for table `z_rank_w_09182` */

DROP TABLE IF EXISTS `z_rank_w_09182`;

CREATE TABLE `z_rank_w_09182` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_w_09182` */

/*Table structure for table `z_rank_w_19738` */

DROP TABLE IF EXISTS `z_rank_w_19738`;

CREATE TABLE `z_rank_w_19738` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '长度',
  PRIMARY KEY (`rank_id`),
  KEY `user_id` (`user_id`),
  KEY `customer_id` (`customer_id`),
  KEY `score_id` (`score_id`),
  KEY `cycles` (`cycles`),
  KEY `time` (`time`),
  KEY `add_time` (`add_time`),
  KEY `length` (`length`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_w_19738` */

insert  into `z_rank_w_19738`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`,`length`) values (44,13,30,152,1,3,1498701835,400),(45,13,30,154,2,5,1498892066,800),(46,13,30,121,4,34,1498892085,1600),(47,13,30,122,5,36,1498892101,2000),(49,13,30,149,3,9,1498893933,1200);

/*Table structure for table `z_rank_w_38596` */

DROP TABLE IF EXISTS `z_rank_w_38596`;

CREATE TABLE `z_rank_w_38596` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_w_38596` */

/*Table structure for table `z_rank_w_42001` */

DROP TABLE IF EXISTS `z_rank_w_42001`;

CREATE TABLE `z_rank_w_42001` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_w_42001` */

insert  into `z_rank_w_42001`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`) values (1,1,25,1,1,200,1498738085),(2,1,25,3,2,333,1498738140),(3,1,25,4,3,444,1498738145),(4,1,25,5,4,888,1498738152),(5,1,25,6,5,2000,1498738170),(6,15,25,7,1,20,1498738226),(7,15,25,8,2,55,1498738230),(8,15,25,9,3,345,1498738243),(9,15,25,10,4,543,1498738248),(10,1,25,11,127,11120,1498738800);

/*Table structure for table `z_rank_w_64113` */

DROP TABLE IF EXISTS `z_rank_w_64113`;

CREATE TABLE `z_rank_w_64113` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_w_64113` */

/*Table structure for table `z_rank_y_09182` */

DROP TABLE IF EXISTS `z_rank_y_09182`;

CREATE TABLE `z_rank_y_09182` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_y_09182` */

/*Table structure for table `z_rank_y_19738` */

DROP TABLE IF EXISTS `z_rank_y_19738`;

CREATE TABLE `z_rank_y_19738` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '长度',
  PRIMARY KEY (`rank_id`),
  KEY `user_id` (`user_id`),
  KEY `customer_id` (`customer_id`),
  KEY `score_id` (`score_id`),
  KEY `cycles` (`cycles`),
  KEY `time` (`time`),
  KEY `add_time` (`add_time`),
  KEY `length` (`length`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_y_19738` */

insert  into `z_rank_y_19738`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`,`length`) values (37,13,30,126,1,12,1467252206,400),(38,13,30,133,2,2,1498890041,800),(39,13,30,149,3,9,1498890143,1200),(40,13,30,131,1,1,1498892470,400);

/*Table structure for table `z_rank_y_38596` */

DROP TABLE IF EXISTS `z_rank_y_38596`;

CREATE TABLE `z_rank_y_38596` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_y_38596` */

/*Table structure for table `z_rank_y_42001` */

DROP TABLE IF EXISTS `z_rank_y_42001`;

CREATE TABLE `z_rank_y_42001` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_y_42001` */

insert  into `z_rank_y_42001`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`) values (1,1,25,1,1,432,1498738085),(2,1,25,3,2,565,1498738140),(3,1,25,4,3,777,1498738145),(4,1,25,5,4,888,1498738152),(5,1,25,6,5,2000,1498738170),(6,15,25,7,1,20,1498738226),(7,15,25,8,2,55,1498738230),(8,15,25,9,3,789,1498738243),(9,15,25,10,4,2004,1498738248);

/*Table structure for table `z_rank_y_64113` */

DROP TABLE IF EXISTS `z_rank_y_64113`;

CREATE TABLE `z_rank_y_64113` (
  `rank_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `score_id` int(11) NOT NULL DEFAULT '0' COMMENT '成绩id',
  `cycles` tinyint(4) NOT NULL DEFAULT '0' COMMENT '圈数',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`rank_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_rank_y_64113` */

/*Table structure for table `z_score_09182` */

DROP TABLE IF EXISTS `z_score_09182`;

CREATE TABLE `z_score_09182` (
  `score_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `begin_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '比赛耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '跑步长度',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `mode` tinyint(4) NOT NULL DEFAULT '0' COMMENT '成绩类型：1训练 2考试 3比赛',
  `flag` int(11) NOT NULL DEFAULT '0' COMMENT '一次成绩的标志',
  PRIMARY KEY (`score_id`),
  KEY `user_id` (`user_id`),
  KEY `time` (`time`),
  KEY `customer_id` (`customer_id`),
  KEY `add_time` (`add_time`),
  KEY `flag` (`flag`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `z_score_09182` */

insert  into `z_score_09182`(`score_id`,`user_id`,`begin_time`,`end_time`,`time`,`add_time`,`length`,`customer_id`,`mode`,`flag`) values (1,14,1232564,12345690,38,0,400,28,1,321459);

/*Table structure for table `z_score_19738` */

DROP TABLE IF EXISTS `z_score_19738`;

CREATE TABLE `z_score_19738` (
  `score_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `begin_time` int(11) NOT NULL DEFAULT '0' COMMENT '开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '结束时间',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '比赛耗时',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '跑步长度',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `mode` tinyint(4) NOT NULL DEFAULT '0' COMMENT '成绩类型：1训练 2考试 3比赛',
  `flag` int(11) NOT NULL DEFAULT '0' COMMENT '一次成绩的标志',
  PRIMARY KEY (`score_id`),
  KEY `user_id` (`user_id`),
  KEY `time` (`time`),
  KEY `customer_id` (`customer_id`),
  KEY `add_time` (`add_time`),
  KEY `flag` (`flag`)
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8;

/*Data for the table `z_score_19738` */

insert  into `z_score_19738`(`score_id`,`user_id`,`begin_time`,`end_time`,`time`,`add_time`,`length`,`customer_id`,`mode`,`flag`) values (89,13,1232564,12345690,17,1498889990,400,30,1,321455),(90,13,1232564,12345690,55,1498890041,400,30,1,321455),(91,13,1232564,12345690,16,1498890143,400,30,1,321455),(92,13,1232564,12345690,20,1498890190,400,30,1,321456),(93,13,1232564,12345690,20,1498890210,400,30,1,321456),(94,13,1232564,12345690,30,1498890234,400,30,1,321456),(95,13,1232564,12345690,30,1498890329,400,30,1,321457),(96,13,1232564,12345690,30,1498890470,400,30,1,321458),(97,13,1232564,12345690,30,1498890503,400,30,1,321459),(98,13,1232564,12345690,30,1498890577,400,30,1,321459),(99,13,1232564,12345690,30,1498890591,400,30,1,321460),(100,13,1232564,12345690,30,1498890904,400,30,1,321461),(101,13,1232564,12345690,30,1498890981,400,30,1,321462),(102,13,1232564,12345690,30,1498891027,400,30,1,321462),(103,13,1232564,12345690,30,1498891055,400,30,1,321463),(104,13,1232564,12345690,30,1498891138,400,30,1,321464),(105,13,1232564,12345690,30,1498891162,400,30,1,321465),(106,13,1232564,12345690,30,1498891218,400,30,1,321466),(107,13,1232564,12345690,30,1498891237,400,30,1,321467),(108,13,1232564,12345690,30,1498891283,400,30,1,321467),(109,13,1232564,12345690,1,1498891297,400,30,1,321467),(110,13,1232564,12345690,1,1498891314,400,30,1,321468),(111,13,1232564,12345690,1,1498891331,400,30,1,321468),(112,13,1232564,12345690,10,1498891411,400,30,1,321469),(113,13,1232564,12345690,10,1498891458,400,30,1,321470),(114,13,1232564,12345690,10,1498891567,400,30,1,321471),(115,13,1232564,12345690,10,1498891616,400,30,1,321472),(116,13,1232564,12345690,10,1498891948,400,30,1,321472),(117,13,1232564,12345690,10,1498891961,400,30,1,321472),(118,13,1232564,12345690,10,1498892045,400,30,1,321473),(119,13,1232564,12345690,20,1498892066,400,30,1,321473),(120,13,1232564,12345690,2,1498892075,400,30,1,321473),(121,13,1232564,12345690,2,1498892085,400,30,1,321473),(122,13,1232564,12345690,2,1498892101,400,30,1,321473),(123,13,1232564,12345690,2,1498892157,400,30,1,321474),(124,13,1232564,12345690,20,1498892170,400,30,1,321474),(125,13,1232564,12345690,12,1498892339,400,30,1,321475),(126,13,1232564,12345690,12,1498892401,400,30,1,321476),(127,13,1232564,12345690,12,1498892414,400,30,1,321476),(128,13,1232564,12345690,50,1498892470,400,30,1,321477),(129,13,1232564,12345690,50,1498892650,400,30,1,321478),(130,13,1232564,12345690,1,1498892664,400,30,1,321478),(131,13,1232564,12345690,1,1498892690,400,30,1,321479),(132,13,1232564,12345690,1,1498892769,400,30,1,321480),(133,13,1232564,12345690,1,1498892784,400,30,1,321480),(134,13,1232564,12345690,1,1498892858,400,30,1,321481),(135,13,1232564,12345690,1,1498893035,400,30,1,321482),(136,13,1232564,12345690,1,1498893104,400,30,1,321483),(137,13,1232564,12345690,1,1498893147,400,30,1,321484),(138,13,1232564,12345690,1,1498893317,400,30,1,321484),(139,13,1232564,12345690,1,1498893357,400,30,1,321485),(140,13,1232564,12345690,1,1498893392,400,30,1,321486),(141,13,1232564,12345690,1,1498893446,400,30,1,321487),(142,13,1232564,12345690,1,1498893527,400,30,1,321488),(143,13,1232564,12345690,1,1498893579,400,30,1,321489),(144,13,1232564,12345690,15,1498893644,400,30,1,321490),(145,13,1232564,12345690,14,1498893702,400,30,1,321491),(146,13,1232564,12345690,14,1498893809,400,30,1,321491),(147,13,1232564,12345690,3,1498893826,400,30,1,321492),(148,13,1232564,12345690,3,1498893867,400,30,1,321492),(149,13,1232564,12345690,3,1498893933,400,30,1,321492),(150,13,1232564,12345690,3,1498894012,400,30,1,321493),(151,13,1232564,12345690,3,1498894044,400,30,1,321493),(152,13,1232564,12345690,3,1498894120,400,30,1,321494),(153,13,1232564,12345690,4,1498894185,400,30,1,321495),(154,13,1232564,12345690,1,1498894194,400,30,1,321495);

/*Table structure for table `z_score_38596` */

DROP TABLE IF EXISTS `z_score_38596`;

CREATE TABLE `z_score_38596` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_score_38596` */

/*Table structure for table `z_score_42001` */

DROP TABLE IF EXISTS `z_score_42001`;

CREATE TABLE `z_score_42001` (
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `z_score_42001` */

insert  into `z_score_42001`(`score_id`,`user_id`,`begin_time`,`end_time`,`time`,`add_time`,`length`,`cycles`,`customer_id`,`mode`) values (1,1,1232564,12345690,200,0,100,1,25,1),(2,1,1232564,12345690,200,0,100,1,25,1),(3,1,1232564,12345690,200,0,100,2,25,1),(4,1,1232564,12345690,200,0,100,3,25,1),(5,1,1232564,12345690,200,0,100,4,25,1),(6,1,1232564,12345690,2000,0,100,5,25,1),(7,15,1232564,12345690,20,0,860,1,25,1),(8,15,1232564,12345690,20,0,860,2,25,1),(9,15,1232564,12345690,200,0,8600,3,25,1),(10,15,1232564,12345690,200,0,8600,4,25,1),(11,15,1232564,12345690,200,0,8600,4,25,1);

/*Table structure for table `z_score_64113` */

DROP TABLE IF EXISTS `z_score_64113`;

CREATE TABLE `z_score_64113` (
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*Data for the table `z_score_64113` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
