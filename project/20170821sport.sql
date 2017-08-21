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
  `img_url` varchar(50) NOT NULL DEFAULT '' COMMENT '广告图片地址',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '广告标题',
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '广告类型',
  `brand_name` varchar(50) NOT NULL DEFAULT '' COMMENT '广告品牌',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序（优先级）',
  `begin_time` int(11) NOT NULL DEFAULT '0' COMMENT '上架时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '下架时间',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0屏蔽 1开启',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '代理商id(拉的客户)',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '插入时间',
  `ad_name` varchar(30) NOT NULL DEFAULT '' COMMENT '广告名',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '投放量',
  `company_name` varchar(50) NOT NULL DEFAULT '' COMMENT '企业名',
  `company_contacts` varchar(30) NOT NULL DEFAULT '' COMMENT '企业联系人',
  `company_phone` int(11) NOT NULL DEFAULT '0' COMMENT '企业联系电话',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `ad` */

insert  into `ad`(`ad_id`,`img_url`,`title`,`type`,`brand_name`,`sort_order`,`begin_time`,`end_time`,`is_show`,`agent_id`,`add_time`,`ad_name`,`count`,`company_name`,`company_contacts`,`company_phone`) values (1,'fasdfij','香飘飘奶茶',1,'香飘飘',1,0,0,1,0,0,'',0,'','',0),(2,'','',0,'',0,0,0,1,0,0,'',0,'','',0),(3,'','',0,'',0,0,0,1,0,0,'',0,'','',0);

/*Table structure for table `ad_record` */

DROP TABLE IF EXISTS `ad_record`;

CREATE TABLE `ad_record` (
  `ad_record_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '代理商id',
  `ad_name` varchar(50) NOT NULL DEFAULT '' COMMENT '广告名',
  `img_url` varchar(50) NOT NULL DEFAULT '' COMMENT '广告图片地址',
  `is_show` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0关闭 1显示',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '广告类型',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `sort_order` tinyint(4) NOT NULL DEFAULT '0' COMMENT '优先级',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '下架时间',
  PRIMARY KEY (`ad_record_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `ad_record` */

insert  into `ad_record`(`ad_record_id`,`customer_id`,`agent_id`,`ad_name`,`img_url`,`is_show`,`type`,`add_time`,`sort_order`,`end_time`) values (1,0,0,'香飘飘','jioasi ',0,0,0,0,0);

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

insert  into `admin`(`admin_id`,`account`,`name`,`passwd`,`add_time`,`is_show`,`last_login_time`,`last_login_ip`,`level`,`grade`,`is_audit`,`login_count`) values (1,'17701804871','admin','00b7691d86d96aebd21dd9e138f90840',1482894847,1,1501237550,'192.168.2.118',1,1,1,74),(16,'17701804870','test','00b7691d86d96aebd21dd9e138f90840',1498619647,1,0,'',2,1,1,0),(17,'17701804872','test','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(18,'17701804873','test','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(21,'17701804876','test','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,0,0),(24,'17701804879','test9','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(25,'17701804800','test5','00b7691d86d96aebd21dd9e138f90840',1484795647,1,2147483647,'192.168.0.118',2,1,1,1),(26,'17701804801','test5','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(27,'17701804807','test5','00b7691d86d96aebd21dd9e138f90840',1484795647,1,0,'',2,1,1,0),(28,'17701804802','test','00b7691d86d96aebd21dd9e138f90840',1484795647,0,0,'',2,1,1,0),(29,'17701804000','test','00b7691d86d96aebd21dd9e138f90840',1498792447,1,0,'',2,1,1,0),(30,'17701804878','管理员','00b7691d86d96aebd21dd9e138f90840',1498801032,1,1498801067,'192.168.0.118',2,1,1,1),(31,'17701804880','管理员2','00b7691d86d96aebd21dd9e138f90840',1498801088,1,0,'',2,1,1,0),(32,'','','',0,1,0,'',0,1,0,0);

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
  `province` varchar(30) NOT NULL DEFAULT '' COMMENT '省份',
  `city` varchar(30) NOT NULL DEFAULT '' COMMENT '市',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0关闭 1启用',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `last_login_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后一次登陆ip',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  PRIMARY KEY (`agent_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `agent` */

insert  into `agent`(`agent_id`,`name`,`account`,`passwd`,`grade`,`rank`,`parent_id`,`agent_address`,`agent_mobile`,`province`,`city`,`is_show`,`last_login_time`,`last_login_ip`,`add_time`,`login_count`) values (1,'上海市代理','111','00b7691d86d96aebd21dd9e138f90840',2,1,0,'上海市、唐镇',2147483647,'上海市','上海市',1,1501552291,'0.0.0.0',1484795647,29),(2,'广东省代理','333','00b7691d86d96aebd21dd9e138f90840',2,1,0,'汕头、xx路',99999,'广东省','',1,1501293363,'0.0.0.0',1484795660,5),(3,'深圳市代理','222','00b7691d86d96aebd21dd9e138f90840',2,2,2,'xx街道xx号',1111110,'','深圳市',1,0,'',1495163660,0),(10,'江西省代理','17701804872','00b7691d86d96aebd21dd9e138f90840',2,1,0,'江西路',2147483647,'江西省','',1,0,'',1495163662,0),(11,'汕头市代理','444','00b7691d86d96aebd21dd9e138f90840',2,1,2,'',0,'广东省','汕头市',1,0,'',0,0);

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
) ENGINE=InnoDB AUTO_INCREMENT=6294 DEFAULT CHARSET=utf8;

/*Data for the table `code` */

insert  into `code`(`id`,`mobile`,`code`,`ip`,`createAt`,`expireAt`,`isUse`,`usingAt`) values (6234,'17701804870','3245','','2017-06-20 16:57:51','2017-06-20 18:58:11',1,'0000-00-00 00:00:00'),(6245,'17701804870','0000','192.168.0.115','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(6246,'17701804870','0000','192.168.0.115','2017-06-20 17:55:13','2017-06-20 18:25:13',1,'0000-00-00 00:00:00'),(6247,'18629013794','0000','192.168.0.116','2017-06-20 18:12:45','2017-06-20 18:42:45',1,'0000-00-00 00:00:00'),(6248,'17701804870','0000','192.168.0.115','2017-06-20 20:01:08','2017-06-20 20:31:08',1,'0000-00-00 00:00:00'),(6249,'17701804870','0000','192.168.0.115','2017-06-20 20:32:27','2017-06-20 21:02:27',1,'0000-00-00 00:00:00'),(6250,'17701804870','0000','192.168.0.115','2017-06-20 20:57:22','2017-06-20 21:27:22',1,'0000-00-00 00:00:00'),(6251,'17701804870','0000','192.168.0.115','2017-06-21 09:36:13','2017-06-21 10:06:13',0,'0000-00-00 00:00:00'),(6252,'18629013794','0000','192.168.0.110','2017-06-21 09:51:28','2017-06-21 10:21:28',1,'0000-00-00 00:00:00'),(6253,'18629013794','0000','192.168.0.110','2017-06-21 14:14:01','2017-06-21 14:44:01',1,'0000-00-00 00:00:00'),(6254,'18629013794','0000','192.168.0.110','2017-06-21 14:15:24','2017-06-21 14:45:24',1,'0000-00-00 00:00:00'),(6255,'13133333333','0000','192.168.0.110','2017-06-21 14:18:30','2017-06-21 14:48:30',0,'0000-00-00 00:00:00'),(6256,'13111111111','0000','192.168.0.110','2017-06-21 14:37:03','2017-06-21 15:07:03',0,'0000-00-00 00:00:00'),(6257,'17701804872','0000','192.168.0.115','2017-06-21 15:14:24','2017-06-21 15:44:24',0,'0000-00-00 00:00:00'),(6258,'17701804875','0000','192.168.0.115','2017-06-21 15:15:56','2017-06-21 15:45:56',1,'0000-00-00 00:00:00'),(6259,'18611111111','0000','192.168.0.110','2017-06-21 15:25:45','2017-06-21 15:55:45',1,'0000-00-00 00:00:00'),(6260,'18611111111','0000','192.168.0.110','2017-06-21 15:26:57','2017-06-21 15:56:57',0,'0000-00-00 00:00:00'),(6261,'17701804876','0000','192.168.0.115','2017-06-21 15:47:10','2017-06-21 16:17:10',0,'0000-00-00 00:00:00'),(6262,'18600000000','0000','192.168.0.110','2017-06-21 15:54:21','2017-06-21 16:24:21',1,'0000-00-00 00:00:00'),(6263,'18600000000','0000','192.168.0.110','2017-06-21 15:55:21','2017-06-21 16:25:21',1,'0000-00-00 00:00:00'),(6264,'18600000000','0000','192.168.0.110','2017-06-21 16:05:27','2017-06-21 16:35:27',1,'0000-00-00 00:00:00'),(6265,'18600000000','0000','192.168.0.110','2017-06-21 16:06:27','2017-06-21 16:36:27',1,'0000-00-00 00:00:00'),(6266,'17701804877','0000','192.168.0.115','2017-06-21 16:11:49','2017-06-21 16:41:49',1,'0000-00-00 00:00:00'),(6267,'17701804877','0000','192.168.0.115','2017-06-21 16:12:54','2017-06-21 16:42:54',1,'0000-00-00 00:00:00'),(6268,'17701804877','0000','192.168.0.115','2017-06-21 16:12:57','2017-06-21 16:42:57',1,'0000-00-00 00:00:00'),(6269,'18600000000','0000','192.168.0.110','2017-06-21 16:14:01','2017-06-21 16:44:01',1,'0000-00-00 00:00:00'),(6270,'17701804877','0000','192.168.0.115','2017-06-21 16:18:15','2017-06-21 16:48:15',1,'0000-00-00 00:00:00'),(6271,'17701804877','0000','192.168.0.115','2017-06-21 16:18:19','2017-06-21 16:48:19',1,'0000-00-00 00:00:00'),(6272,'18600000000','0000','192.168.0.110','2017-06-21 16:18:29','2017-06-21 16:48:29',1,'0000-00-00 00:00:00'),(6273,'18600000000','0000','192.168.0.110','2017-06-21 16:22:03','2017-06-21 16:52:03',1,'0000-00-00 00:00:00'),(6274,'18629013794','0000','192.168.0.110','2017-06-21 16:45:25','2017-06-21 17:15:25',0,'0000-00-00 00:00:00'),(6275,'18600000000','0000','192.168.0.110','2017-06-21 16:48:11','2017-06-21 17:18:11',1,'0000-00-00 00:00:00'),(6276,'18600000000','0000','192.168.0.110','2017-06-21 16:49:24','2017-06-21 17:19:24',1,'0000-00-00 00:00:00'),(6277,'18600000000','0000','192.168.0.110','2017-06-21 16:54:02','2017-06-21 17:24:02',1,'0000-00-00 00:00:00'),(6278,'18600000000','0000','192.168.0.110','2017-06-21 17:05:09','2017-06-21 17:35:09',1,'0000-00-00 00:00:00'),(6279,'18600000000','0000','192.168.0.110','2017-06-21 17:06:58','2017-06-21 17:36:58',1,'0000-00-00 00:00:00'),(6280,'18600000000','0000','192.168.0.110','2017-06-21 17:13:45','2017-06-21 17:43:45',0,'0000-00-00 00:00:00'),(6281,'18600000001','0000','192.168.0.110','2017-06-21 17:14:38','2017-06-21 17:44:38',0,'0000-00-00 00:00:00'),(6282,'18600000002','0000','192.168.0.110','2017-06-21 17:42:33','2017-06-21 18:12:33',1,'0000-00-00 00:00:00'),(6283,'18600000002','0000','192.168.0.110','2017-06-21 17:46:41','2017-06-21 18:16:41',0,'0000-00-00 00:00:00'),(6284,'18600000003','0000','192.168.0.106','2017-06-23 18:35:11','2017-06-23 19:05:11',1,'0000-00-00 00:00:00'),(6285,'18600000003','0000','192.168.0.107','2017-06-26 10:55:51','2017-06-26 11:25:51',0,'0000-00-00 00:00:00'),(6286,'18600000009','0000','192.168.0.107','2017-06-27 09:40:17','2017-06-27 10:10:17',1,'0000-00-00 00:00:00'),(6287,'18600000009','0000','192.168.0.107','2017-06-27 09:42:37','2017-06-27 10:12:37',1,'0000-00-00 00:00:00'),(6288,'17701804875','0000','192.168.0.118','2017-06-27 09:51:24','2017-06-27 10:21:24',0,'0000-00-00 00:00:00'),(6289,'17701804878','0000','192.168.0.118','2017-06-27 09:57:54','2017-06-27 10:27:54',0,'0000-00-00 00:00:00'),(6290,'17701804877','0000','192.168.0.118','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(6291,'18600000009','0000','192.168.0.105','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(6292,'18600000009','0000','192.168.0.100','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'0000-00-00 00:00:00'),(6293,'18600000009','0000','192.168.0.100','0000-00-00 00:00:00','0000-00-00 00:00:00',0,'0000-00-00 00:00:00');

/*Table structure for table `college_dept` */

DROP TABLE IF EXISTS `college_dept`;

CREATE TABLE `college_dept` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `dept_name` varchar(30) NOT NULL DEFAULT '' COMMENT '系别',
  `grade_num` tinyint(4) NOT NULL DEFAULT '0' COMMENT '有几个年级',
  `class_list` varchar(500) NOT NULL DEFAULT '' COMMENT '班级列表',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `college_dept` */

insert  into `college_dept`(`id`,`customer_id`,`dept_name`,`grade_num`,`class_list`,`add_time`) values (11,31,'空乘系',0,'',1503297429),(12,31,'物理系',0,'',1503297463),(13,31,'数学系',0,'',1503298948),(14,31,'文学系',0,'',1503299059),(15,31,'机械系',0,'',1503299153),(16,31,'量子系',0,'',1503299314);

/*Table structure for table `contest` */

DROP TABLE IF EXISTS `contest`;

CREATE TABLE `contest` (
  `contest_id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '学校id',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父级id',
  `contest_sn` char(8) NOT NULL DEFAULT '' COMMENT '比赛的编码',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '比赛的标题',
  `content` varchar(50) NOT NULL DEFAULT '' COMMENT '描述',
  `length_male` int(11) NOT NULL DEFAULT '0' COMMENT '男子考核内容',
  `length_female` int(11) NOT NULL DEFAULT '0' COMMENT '女子考核内容',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '多少长度的比赛',
  `pass_score_male` varchar(30) NOT NULL DEFAULT '' COMMENT '男生合格成绩',
  `pass_score_female` varchar(30) NOT NULL DEFAULT '' COMMENT '女生合格成绩',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `begin_time` int(11) NOT NULL DEFAULT '0' COMMENT '比赛开始时间',
  `end_time` int(11) DEFAULT '0' COMMENT '比赛结束时间',
  `from_id` int(11) NOT NULL DEFAULT '0' COMMENT '创建者id',
  `from_name` varchar(30) NOT NULL DEFAULT '' COMMENT '创建者名字',
  `mode` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1考试 2比赛',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0取消 1正常',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0取消 1未开始 2赛事准备中 3赛事进行中 4赛事完成',
  PRIMARY KEY (`contest_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8;

/*Data for the table `contest` */

insert  into `contest`(`contest_id`,`customer_id`,`parent_id`,`contest_sn`,`title`,`content`,`length_male`,`length_female`,`length`,`pass_score_male`,`pass_score_female`,`add_time`,`begin_time`,`end_time`,`from_id`,`from_name`,`mode`,`is_show`,`status`) values (57,31,0,'62943873','交通大学 夏季运动会','天气转凉 注意保暖',1500,1000,0,'671','610',1503305882,1503244800,1503307800,31,'学校管理员',1,1,4),(63,31,57,'19852263','交通大学 夏季运动会(补考)','天气转凉 注意保暖',1500,1000,0,'671','610',1503307594,1503244800,1503331140,31,'学校管理员',1,1,1);

/*Table structure for table `contest_order` */

DROP TABLE IF EXISTS `contest_order`;

CREATE TABLE `contest_order` (
  `contest_order_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `contest_sn` char(8) NOT NULL DEFAULT '0' COMMENT '比赛的编码（赛事 和 其补考共用一个编码）',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '学校对应的id',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(30) NOT NULL COMMENT '用户名',
  `studentId` varchar(15) NOT NULL COMMENT '用户学号',
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1男  2女',
  `dept` varchar(30) NOT NULL DEFAULT '' COMMENT '系别',
  `grade` tinyint(4) NOT NULL DEFAULT '0' COMMENT '年级',
  `class` varchar(30) NOT NULL DEFAULT '' COMMENT '班级',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '比赛的长度',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '用时(成绩)',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '用户添加时间',
  `update` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `begin_time` int(11) NOT NULL DEFAULT '0' COMMENT '比赛开始时间',
  `end_time` int(11) NOT NULL DEFAULT '0' COMMENT '比赛结束时间',
  `makeup_time` int(11) DEFAULT '0' COMMENT '补考时间',
  `mode` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1考试 2赛事',
  `sign` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未签到 1已签到',
  `confirm` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未确认 1已确认',
  `makeup` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未补考  1,2,3..已补考',
  `up_standard` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0不合格  1合格',
  PRIMARY KEY (`contest_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=365 DEFAULT CHARSET=utf8;

/*Data for the table `contest_order` */

insert  into `contest_order`(`contest_order_id`,`contest_sn`,`customer_id`,`user_id`,`name`,`studentId`,`sex`,`dept`,`grade`,`class`,`length`,`time`,`add_time`,`update`,`begin_time`,`end_time`,`makeup_time`,`mode`,`sign`,`confirm`,`makeup`,`up_standard`) values (316,'62943873',31,22,'段齐平','11432',1,'美术系',1,'信息一班',1500,11,1503305894,0,0,0,0,1,1,0,0,1),(317,'62943873',31,43,'张大伟','7654677',1,'数学系',3,'二班',1500,222,1503305894,0,0,0,0,1,1,0,0,1),(318,'62943873',31,51,'欧阳疯','7657',1,'物理系',2,'航天二班',1500,33,1503305894,0,0,0,0,1,1,0,0,1),(319,'62943873',31,69,'张三','43214',1,'美术系',2,'信息二班',1500,55,1503305894,0,0,0,0,1,1,0,0,1),(320,'62943873',31,87,'李大山','2017005468',1,'物理系',1,'信息一班',1500,22,1503305894,0,0,0,0,1,1,0,0,1),(321,'62943873',31,14,'11111111111111','43214',1,'美术系',2,'信息二班',1500,444,1503305906,0,0,0,0,1,1,0,0,1),(322,'62943873',31,70,'王五11','745676',1,'美术系',3,'信息二班',1500,55555,1503305906,0,0,0,0,1,1,0,0,0),(323,'62943873',31,78,'王五','745676',1,'美术系',3,'信息二班',1500,55,1503305906,0,0,0,0,1,1,0,0,1),(324,'62943873',31,19,'张大伟','7654677',1,'数学系',3,'二班',1500,66,1503305925,0,0,0,0,1,1,0,0,1),(325,'62943873',31,20,'吕子乔','76456',1,'数学系',4,'二班',1500,666,1503305925,0,0,0,0,1,1,0,0,1),(326,'62943873',31,28,'张大伟','7654677',1,'数学系',3,'二班',1500,0,1503305925,0,0,0,0,1,0,0,0,1),(327,'62943873',31,29,'吕子乔123','76456',1,'数学系',4,'二班',1500,0,1503305925,0,0,0,0,1,0,0,0,0),(328,'62943873',31,44,'吕子乔','76456',1,'数学系',4,'二班',1500,0,1503305925,0,0,0,0,1,0,0,0,0),(329,'62943873',31,52,'张大伟','7654677',1,'数学系',3,'二班',1500,0,1503305925,0,0,0,0,1,0,0,0,0),(330,'62943873',31,53,'吕子乔','76456',1,'数学系',4,'二班',1500,0,1503305925,0,0,0,0,1,0,0,0,0),(331,'62943873',31,74,'张大伟','7654677',1,'数学系',3,'二班',1500,0,1503305925,0,0,0,0,1,0,0,0,0),(332,'62943873',31,75,'吕子乔','76456',1,'数学系',4,'二班',1500,0,1503305925,0,0,0,0,1,0,0,0,0),(333,'62943873',31,82,'张大伟','7654677',1,'数学系',3,'二班',1500,0,1503305925,0,0,0,0,1,0,0,0,0),(357,'19852263',31,29,'吕子乔','76456',1,'数学系',4,'二班',1500,0,1503307594,0,0,0,0,1,0,0,0,0),(358,'19852263',31,44,'吕子乔12345','76456',1,'数学系',4,'二班',1500,0,1503307594,0,0,0,0,1,0,0,0,0),(359,'19852263',31,52,'张大伟','7654677',1,'数学系',3,'二班',1500,0,1503307594,0,0,0,0,1,0,0,0,0),(360,'19852263',31,53,'吕子乔','76456',1,'数学系',4,'二班',1500,0,1503307594,0,0,0,0,1,0,0,0,0),(361,'19852263',31,74,'张大伟','7654677',1,'数学系',3,'二班',1500,0,1503307594,0,0,0,0,1,0,0,0,0),(362,'19852263',31,75,'吕子乔','76456',1,'数学系',4,'二班',1500,0,1503307594,0,0,0,0,1,0,0,0,0),(363,'19852263',31,82,'张大伟','7654677',1,'数学系',3,'二班',1500,0,1503307594,0,0,0,0,1,0,0,0,0),(364,'19852263',31,70,'王五','745676',1,'美术系',3,'信息二班',1500,0,1503308352,0,0,0,0,1,0,0,0,0);

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
  `device_num` int(11) NOT NULL DEFAULT '0' COMMENT '设备数量',
  `province` varchar(30) NOT NULL DEFAULT '' COMMENT '省',
  `city` varchar(30) NOT NULL DEFAULT '' COMMENT '市',
  `grade` tinyint(4) NOT NULL DEFAULT '3' COMMENT '用户级别',
  `score_table` varchar(30) NOT NULL DEFAULT '' COMMENT '对应成绩表',
  `rank_y_table` varchar(30) NOT NULL DEFAULT '' COMMENT '年成绩排行表',
  `rank_m_table` varchar(30) NOT NULL DEFAULT '' COMMENT '月成绩排行榜',
  `rank_w_table` varchar(30) NOT NULL DEFAULT '' COMMENT '周成绩排行榜',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1学校 2运动场',
  `school_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1大学 2中学 3小学',
  `length` int(11) NOT NULL DEFAULT '400' COMMENT '跑道长度',
  `is_show` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0屏蔽 1开启',
  `add_time` char(20) NOT NULL DEFAULT '0',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `last_login_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后一次登陆ip',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `longitude_y` varchar(50) NOT NULL DEFAULT '' COMMENT '经度',
  `latitude_x` varchar(50) NOT NULL DEFAULT '' COMMENT '维度',
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

/*Data for the table `customer` */

insert  into `customer`(`customer_id`,`code`,`name`,`account`,`passwd`,`agent_id`,`customer_addr`,`device_num`,`province`,`city`,`grade`,`score_table`,`rank_y_table`,`rank_m_table`,`rank_w_table`,`type`,`school_type`,`length`,`is_show`,`add_time`,`last_login_time`,`last_login_ip`,`login_count`,`longitude_y`,`latitude_x`) values (31,'34695','上海交通大学(闵行校区)','17701800001','00b7691d86d96aebd21dd9e138f90840',1,'上海市',1,'上海市','上海市',3,'z_score_34695','z_rank_y_34695','z_rank_m_34695','z_rank_w_34695',1,1,400,1,'1499051054',1503280659,'0.0.0.0',225,'121.4426140000','31.0315830000'),(32,'93035','华东师范大学(普陀校区)','17701800002','00b7691d86d96aebd21dd9e138f90840',1,'上海市',1,'','',3,'z_score_93035','z_rank_y_93035','z_rank_m_93035','z_rank_w_93035',1,1,400,1,'1499051143',1501486064,'0.0.0.0',1,'121.4121190000','31.2331680000'),(33,'62679','上海科技大学(张江校区)','17701800003','00b7691d86d96aebd21dd9e138f90840',1,'上海市',1,'','',3,'z_score_62679','z_rank_y_62679','z_rank_m_62679','z_rank_w_62679',1,1,200,1,'1499051187',0,'',0,'121.5979640000','31.1856800000'),(34,'95048','复旦大学(邯郸校区)','17701800004','00b7691d86d96aebd21dd9e138f90840',1,'上海市',1,'','',3,'z_score_95048','z_rank_y_95048','z_rank_m_95048','z_rank_w_95048',1,1,400,1,'1499154016',0,'',0,'121.5109990000','31.3015280000'),(35,'90290','同济大学(四平路校区) ','17701800005','00b7691d86d96aebd21dd9e138f90840',1,'上海市',1,'','',3,'z_score_90290','z_rank_y_90290','z_rank_m_90290','z_rank_w_90290',1,1,800,1,'1499154072',0,'',0,'121.5083170000','31.2889970000'),(37,'79307','华东理工大学(徐汇校区) ','17701800006','00b7691d86d96aebd21dd9e138f90840',1,'上海市',1,'','',3,'z_score_79307','z_rank_y_79307','z_rank_m_79307','z_rank_w_79307',1,1,0,1,'1499329318',0,'',0,'121.4310178657','31.1502551756'),(45,'82337','上海大学','17701800007','00b7691d86d96aebd21dd9e138f90840',0,'上海市、普陀区',3,'','',3,'z_score_82337','z_rank_y_82337','z_rank_m_82337','z_rank_w_82337',1,1,400,1,'1503283615',0,'',0,'3213546','4568788'),(46,'53183','普陀小学','17701800008','00b7691d86d96aebd21dd9e138f90840',0,'上海 普陀区 武宁路',3,'','',3,'z_score_53183','z_rank_y_53183','z_rank_m_53183','z_rank_w_53183',1,3,200,1,'1503284192',0,'',0,'12354896','3549841318');

/*Table structure for table `device` */

DROP TABLE IF EXISTS `device`;

CREATE TABLE `device` (
  `device_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` int(11) NOT NULL DEFAULT '0' COMMENT '手环编码',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '代理商id',
  PRIMARY KEY (`device_id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8;

/*Data for the table `device` */

insert  into `device`(`device_id`,`code`,`user_id`,`agent_id`) values (51,1,1,1),(52,2,0,1),(53,3,15,1),(54,4,16,1),(55,5,17,1),(56,6,18,1),(57,7,19,1),(58,8,20,1),(59,9,22,1),(60,10,23,1),(61,11,24,1),(62,12,25,1),(63,13,26,1),(64,14,27,1),(65,15,28,1),(66,16,29,1),(67,17,37,1),(68,18,38,1),(69,19,39,1),(70,20,40,1),(71,21,41,1),(72,22,42,1),(73,23,43,1),(74,24,44,1),(75,25,46,1),(76,26,47,1),(77,27,48,1),(78,28,49,1),(79,29,50,1),(80,30,51,1),(81,31,52,1),(82,32,53,1),(83,33,68,1),(84,34,69,1),(85,35,70,1),(86,36,71,1),(87,37,72,1),(88,38,73,1),(89,39,74,1),(90,40,75,1),(91,41,76,1),(92,42,77,1),(93,43,78,1),(94,44,79,1),(95,45,80,1),(96,46,81,1),(97,47,82,1),(98,48,83,1),(99,49,84,1),(100,50,85,1),(101,51,86,1),(102,52,87,1),(105,53,0,1);

/*Table structure for table `device_ms` */

DROP TABLE IF EXISTS `device_ms`;

CREATE TABLE `device_ms` (
  `device_ms_id` int(11) NOT NULL AUTO_INCREMENT,
  `ms_code` char(7) NOT NULL DEFAULT '' COMMENT '主机编码',
  `passwd` int(11) NOT NULL DEFAULT '123456' COMMENT '机器密码',
  `next_ms_code` char(7) NOT NULL DEFAULT '' COMMENT '下一个设备',
  `next_ms_length` int(11) NOT NULL DEFAULT '0' COMMENT '到下一个主机距离',
  `last_ms_code` char(7) NOT NULL DEFAULT '0' COMMENT '上一个设备',
  `last_expire_time` int(11) NOT NULL DEFAULT '0' COMMENT '和上一个设备的有效时间',
  `stay` int(11) NOT NULL DEFAULT '10' COMMENT '停留时间',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '代理商id',
  `type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1学校 2运动场',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `customer_name` varchar(50) NOT NULL DEFAULT '' COMMENT '客户名',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '投放使用时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1正常 0故障',
  `signal` varchar(30) NOT NULL DEFAULT '' COMMENT '信号强度',
  `is_register` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0未注册  1已注册',
  `isPoint` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0经过点 1起点',
  PRIMARY KEY (`device_ms_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `device_ms` */

insert  into `device_ms`(`device_ms_id`,`ms_code`,`passwd`,`next_ms_code`,`next_ms_length`,`last_ms_code`,`last_expire_time`,`stay`,`agent_id`,`type`,`customer_id`,`customer_name`,`add_time`,`status`,`signal`,`is_register`,`isPoint`) values (1,'0000111',123456,'0000112',100,'0000112',12,10,1,1,31,'上海交通大学(闵行校区)',1501038847,1,'',1,1),(3,'0000112',123456,'0000111',200,'0000111',10,10,1,1,31,'上海交通大学(闵行校区)',1501038847,1,'',1,0),(4,'0000113',123456,'0000111',100,'0000112',9,10,1,1,31,'上海交通大学(闵行校区)',1501038847,1,'',1,0);

/*Table structure for table `device_order` */

DROP TABLE IF EXISTS `device_order`;

CREATE TABLE `device_order` (
  `device_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `order_sn` varchar(30) NOT NULL DEFAULT '' COMMENT '工单号',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0取消 1待处理 2处理中 3完成 4客户确认完成',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `customer_name` varchar(30) NOT NULL DEFAULT '' COMMENT '客户名',
  `customer_addr` varchar(200) NOT NULL DEFAULT '' COMMENT '客户地址',
  `desc` text NOT NULL COMMENT '客户描述',
  `ms_code` int(11) NOT NULL DEFAULT '0' COMMENT '主机编码',
  `contact_name` varchar(30) NOT NULL DEFAULT '' COMMENT '联系人姓名',
  `contact_mobile` char(11) NOT NULL DEFAULT '' COMMENT '联系人手机号',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0报修 1咨询',
  `agent_id` int(11) NOT NULL DEFAULT '0' COMMENT '供应商id',
  `agent_name` varchar(30) NOT NULL DEFAULT '' COMMENT '供应商名',
  `agent_mobile` char(11) NOT NULL DEFAULT '' COMMENT '供应商联系方式',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '工单生成时间',
  `accept_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '受理时间',
  `finish_time` int(11) NOT NULL DEFAULT '0' COMMENT '完成时间',
  `agent_desc` varchar(200) NOT NULL DEFAULT '' COMMENT '供应商描述',
  `breakdown_report` varchar(200) NOT NULL DEFAULT '' COMMENT '设备故障报告',
  PRIMARY KEY (`device_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `device_order` */

insert  into `device_order`(`device_order_id`,`order_sn`,`status`,`customer_id`,`customer_name`,`customer_addr`,`desc`,`ms_code`,`contact_name`,`contact_mobile`,`type`,`agent_id`,`agent_name`,`agent_mobile`,`add_time`,`accept_time`,`finish_time`,`agent_desc`,`breakdown_report`) values (36,'1707281117100000317170',4,31,'上海交通大学(闵行校区)','上海市','屏幕坏了',111100,'李老师','17701804877',1,1,'上海代理','17701804800',1501211830,1501211899,2147483647,'',''),(37,'1707281142280000312740',1,31,'上海交通大学(闵行校区)','上海市','没有信号',11223,'张老师','17701804878',0,1,'','',1501213348,0,0,'','');

/*Table structure for table `honor` */

DROP TABLE IF EXISTS `honor`;

CREATE TABLE `honor` (
  `honor_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '奖章',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型 1累计公里 2累计时间',
  `grade` int(11) NOT NULL DEFAULT '0' COMMENT '分数',
  `img` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`honor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `honor` */

insert  into `honor`(`honor_id`,`name`,`type`,`grade`,`img`,`add_time`) values (1,'5公里挑战',1,5000,'',1499052156),(2,'坚持运动',2,7,'',1499052159);

/*Table structure for table `honor_order` */

DROP TABLE IF EXISTS `honor_order`;

CREATE TABLE `honor_order` (
  `honor_order_id` int(11) NOT NULL AUTO_INCREMENT,
  `honor_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `add_time` int(11) NOT NULL DEFAULT '0',
  `honor_type` tinyint(4) NOT NULL DEFAULT '0',
  `grade` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`honor_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `honor_order` */

insert  into `honor_order`(`honor_order_id`,`honor_id`,`user_id`,`add_time`,`honor_type`,`grade`) values (1,1,15,1499052156,1,5000),(2,2,15,1499052170,2,7),(3,1,16,1499052190,1,5000);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `rank_marathon` */

insert  into `rank_marathon`(`rank_id`,`user_id`,`customer_id`,`score_id`,`cycles`,`time`,`add_time`,`length`) values (6,14,31,111,26,21312,1499052156,400),(7,15,31,222,26,5435,1499052159,400),(8,14,31,333,52,6456,1499052157,400),(9,15,31,444,105,4123434,1499052157,400);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `rank_singe` */

insert  into `rank_singe`(`rank_id`,`user_id`,`customer_id`,`score_id`,`time`,`add_time`,`length`) values (8,15,31,5,47,1499051801,400),(9,14,31,6,47,1499051844,400);

/*Table structure for table `record_message` */

DROP TABLE IF EXISTS `record_message`;

CREATE TABLE `record_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '长度',
  `time` int(11) NOT NULL DEFAULT '0' COMMENT '用时',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '用户名',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `record_message` */

insert  into `record_message`(`id`,`length`,`time`,`user_id`,`name`,`customer_id`,`add_time`) values (2,1600,57,1,'齐平',31,1502950376),(3,1600,51,16,'李四',31,1502950446),(4,2000,68,16,'王二',31,1502950457),(5,1200,9,17,'张三',31,1502950535),(6,1600,21,17,'周五',31,1502950613),(8,0,0,0,'',0,0);

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
  `dept` varchar(50) NOT NULL DEFAULT '' COMMENT '系别',
  `class` varchar(50) NOT NULL DEFAULT '' COMMENT '班级',
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `teacher` */

insert  into `teacher`(`teacher_id`,`customer_id`,`name`,`account`,`passwd`,`add_time`,`is_show`,`last_login_time`,`last_login_ip`,`login_count`,`grade`,`dept`,`class`) values (1,31,'王波','111222','00b7691d86d96aebd21dd9e138f90840',1498554051,1,2147483647,'192.168.0.118',3,4,'数学系','信息一班'),(2,31,'李老师','17701800004','00b7691d86d96aebd21dd9e138f90840',1498554052,1,2147483647,'192.168.0.117',1,4,'数学系','信息二班'),(3,31,'张老师','17701800005','00b7691d86d96aebd21dd9e138f90840',1498554085,0,2147483647,'192.168.0.116',2,4,'影视系','影视一班'),(4,31,'戴老师','17701800001','00b7691d86d96aebd21dd9e138f90840',1499828108,1,1500953612,'0.0.0.0',5,4,'美术系','一班'),(5,31,'佘老师','17701800003','d41d8cd98f00b204e9800998ecf8427e',1499828256,1,0,'',0,4,'体育系','体育一班'),(6,31,'杜老师','17701808888','698d51a19d8a121ce581499d7b701668',1499828440,1,0,'',0,4,'11','11'),(7,31,'21','17701800009','698d51a19d8a121ce581499d7b701668',1499828524,1,0,'',0,4,'11','11'),(8,31,'333','17701800010','bcbe3365e6ac95ea2c0343a2395834dd',1499840135,1,0,'',0,4,'222','222');

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `is_check` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1合法 2非法',
  `account` char(11) NOT NULL DEFAULT '0' COMMENT '手机号',
  `passwd` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `nick` varchar(50) NOT NULL DEFAULT '' COMMENT '昵称',
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '真实姓名',
  `img` varchar(100) NOT NULL DEFAULT '' COMMENT '头像路径',
  `email` varchar(50) NOT NULL DEFAULT '' COMMENT '邮箱',
  `qq` int(11) NOT NULL DEFAULT '0' COMMENT 'qq号',
  `weixin` varchar(50) NOT NULL DEFAULT '' COMMENT '微信号',
  `sex` tinyint(4) NOT NULL DEFAULT '1' COMMENT '性别 1男 2女',
  `height` tinyint(4) NOT NULL DEFAULT '0' COMMENT '身高',
  `weight` tinyint(4) NOT NULL DEFAULT '0' COMMENT '体重',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `school` varchar(30) NOT NULL DEFAULT '' COMMENT '学校',
  `school_num` int(11) NOT NULL DEFAULT '0' COMMENT '学校编号',
  `dept` varchar(30) NOT NULL DEFAULT '' COMMENT '系别',
  `grade` tinyint(4) NOT NULL DEFAULT '0' COMMENT '年级',
  `class` varchar(30) NOT NULL DEFAULT '' COMMENT '班级',
  `teacher_id` int(11) NOT NULL COMMENT '老师id',
  `studentId` varchar(15) NOT NULL DEFAULT '0' COMMENT '学号',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1学生 2体育爱好者',
  `customer_id` int(11) NOT NULL DEFAULT '0' COMMENT '客户id',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后一次登陆时间',
  `last_login_ip` varchar(30) NOT NULL DEFAULT '' COMMENT '最后一次登陆ip',
  `login_count` int(11) NOT NULL DEFAULT '0' COMMENT '登陆次数',
  `length` int(11) NOT NULL DEFAULT '0' COMMENT '累计长度',
  PRIMARY KEY (`user_id`,`nick`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8;

/*Data for the table `user` */

insert  into `user`(`user_id`,`is_check`,`account`,`passwd`,`nick`,`name`,`img`,`email`,`qq`,`weixin`,`sex`,`height`,`weight`,`add_time`,`school`,`school_num`,`dept`,`grade`,`class`,`teacher_id`,`studentId`,`type`,`customer_id`,`last_login_time`,`last_login_ip`,`login_count`,`length`) values (1,1,'17701804871','e10adc3949ba59abbe56e057f20f883e','齐平66','段齐平666','public/guest/upload/photo/17701804876/17701804876head.png','pksanwei@163.com',827068977,'fiosah',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',1,'信息一班',1,'11432',0,31,2147483647,'192.168.0.118',1,34400),(14,1,'17701804000','00b7691d86d96aebd21dd9e138f90840','111111111111','11111111111111','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',2,'信息二班',2,'43214',0,31,0,'',0,23600),(15,1,'18600000001','4297f44b13955235245b2497399d7a93','18600000000','王五','public/guest/upload/photo/18600000000/18600000000head.jpg','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',3,'信息二班',3,'745676',0,31,1499153756,'192.168.0.105',171,41600),(16,1,'18600000002','e10adc3949ba59abbe56e057f20f883e','18600000001','李四','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',4,'航天一班',3,'7676',0,31,0,'',0,29400),(17,1,'18600000003','4297f44b13955235245b2497399d7a93','18600000003','上官云','public/guest/upload/photo/18600000003/18600000003head.jpg','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',1,'航天一班',2,'764676',0,31,1498705190,'192.168.0.106',8,17600),(18,1,'17701804004','00b7691d86d96aebd21dd9e138f90840','17701804875','欧阳疯','public/guest/upload/photo/17701804875/17701804875head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',2,'航天二班',1,'7657',0,31,0,'',0,800),(19,1,'17701804005','00b7691d86d96aebd21dd9e138f90840','17701804878','张大伟','public/guest/upload/photo/17701804878/17701804878head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',3,'二班',1,'7654677',0,31,2147483647,'192.168.0.118',2,0),(20,1,'18600000006','4297f44b13955235245b2497399d7a93','18600000009','吕子乔','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',4,'二班',0,'76456',0,31,0,'',0,0),(22,1,'17701804007','e10adc3949ba59abbe56e057f20f883e','齐平','段齐平','public/guest/upload/photo/17701804876/17701804876head.png','pksanwei@163.com',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',1,'信息一班',0,'11432',0,31,0,'',0,0),(23,1,'17701804008','00b7691d86d96aebd21dd9e138f90840','段齐平22','张三','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',2,'信息二班',0,'43214',0,31,0,'',0,0),(24,1,'18600000009','4297f44b13955235245b2497399d7a93','18600000000','王五','public/guest/upload/photo/18600000000/18600000000head.jpg','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',3,'信息二班',0,'745676',0,31,0,'',0,0),(25,1,'18600000010','e10adc3949ba59abbe56e057f20f883e','18600000001','李四','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',4,'航天一班',0,'7676',0,31,0,'',0,0),(26,1,'18600000011','4297f44b13955235245b2497399d7a93','18600000003','上官云','public/guest/upload/photo/18600000003/18600000003head.jpg','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',1,'航天一班',0,'764676',0,31,0,'',0,0),(27,1,'17701804012','00b7691d86d96aebd21dd9e138f90840','17701804875','欧阳疯','public/guest/upload/photo/17701804875/17701804875head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',2,'航天二班',0,'7657',0,31,0,'',0,0),(28,1,'17701804013','00b7691d86d96aebd21dd9e138f90840','17701804878','张大伟','public/guest/upload/photo/17701804878/17701804878head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',3,'二班',0,'7654677',0,31,0,'',0,0),(29,1,'18600000014','4297f44b13955235245b2497399d7a93','18600000009','吕子乔','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',4,'二班',0,'76456',0,31,0,'',0,0),(37,1,'17701804015','e10adc3949ba59abbe56e057f20f883e','齐平','段齐平','public/guest/upload/photo/17701804876/17701804876head.png','pksanwei@163.com',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',1,'信息一班',0,'11432',0,31,0,'',0,0),(38,1,'17701804016','00b7691d86d96aebd21dd9e138f90840','段齐平22','张三','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',2,'信息二班',0,'43214',0,31,0,'',0,0),(39,1,'18600000017','4297f44b13955235245b2497399d7a93','18600000000','王五','public/guest/upload/photo/18600000000/18600000000head.jpg','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',3,'信息二班',0,'745676',0,31,0,'',0,0),(40,1,'18600000018','e10adc3949ba59abbe56e057f20f883e','18600000001','李四','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',4,'航天一班',0,'7676',0,31,0,'',0,0),(41,1,'18600000019','4297f44b13955235245b2497399d7a93','18600000003','上官云','public/guest/upload/photo/18600000003/18600000003head.jpg','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',1,'航天一班',0,'764676',0,31,0,'',0,4000),(42,1,'17701804020','00b7691d86d96aebd21dd9e138f90840','17701804875','欧阳疯','public/guest/upload/photo/17701804875/17701804875head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',2,'航天二班',0,'7657',0,31,0,'',0,0),(43,1,'17701804021','00b7691d86d96aebd21dd9e138f90840','17701804878','张大伟','public/guest/upload/photo/17701804878/17701804878head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',3,'二班',0,'7654677',0,31,0,'',0,0),(44,1,'18600000022','4297f44b13955235245b2497399d7a93','18600000009','吕子乔','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',4,'二班',0,'76456',0,31,0,'',0,0),(46,1,'17701804023','e10adc3949ba59abbe56e057f20f883e','齐平','段齐平','public/guest/upload/photo/17701804876/17701804876head.png','pksanwei@163.com',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',1,'信息一班',0,'11432',0,31,0,'',0,0),(47,1,'17701804024','00b7691d86d96aebd21dd9e138f90840','段齐平22','张三','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',2,'信息二班',0,'43214',0,31,0,'',0,0),(48,1,'18600000025','4297f44b13955235245b2497399d7a93','18600000000','王五','public/guest/upload/photo/18600000000/18600000000head.jpg','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',3,'信息二班',0,'745676',0,31,0,'',0,0),(49,1,'18600000026','e10adc3949ba59abbe56e057f20f883e','18600000001','李四','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',4,'航天一班',0,'7676',0,31,0,'',0,3000),(50,1,'18600000027','4297f44b13955235245b2497399d7a93','18600000003','上官云','public/guest/upload/photo/18600000003/18600000003head.jpg','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',1,'航天一班',0,'764676',0,31,0,'',0,3000),(51,1,'17701804028','00b7691d86d96aebd21dd9e138f90840','17701804875','欧阳疯','public/guest/upload/photo/17701804875/17701804875head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',2,'航天二班',0,'7657',0,31,0,'',0,0),(52,1,'17701804029','00b7691d86d96aebd21dd9e138f90840','17701804878','张大伟','public/guest/upload/photo/17701804878/17701804878head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',3,'二班',0,'7654677',0,31,0,'',0,0),(53,1,'18600000030','4297f44b13955235245b2497399d7a93','18600000009','吕子乔','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',4,'二班',0,'76456',0,31,0,'',0,0),(68,1,'17701804031','e10adc3949ba59abbe56e057f20f883e','齐平','段齐平','public/guest/upload/photo/17701804876/17701804876head.png','pksanwei@163.com',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',1,'信息一班',0,'11432',0,31,0,'',0,0),(69,1,'17701804032','00b7691d86d96aebd21dd9e138f90840','段齐平22','张三','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',2,'信息二班',0,'43214',0,31,0,'',0,0),(70,1,'18600000033','4297f44b13955235245b2497399d7a93','18600000000','王五','public/guest/upload/photo/18600000000/18600000000head.jpg','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',3,'信息二班',0,'745676',0,31,0,'',0,0),(71,1,'18600000034','e10adc3949ba59abbe56e057f20f883e','18600000001','李四','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',4,'航天一班',0,'7676',0,31,0,'',0,1000),(72,1,'18600000035','4297f44b13955235245b2497399d7a93','18600000003','上官云','public/guest/upload/photo/18600000003/18600000003head.jpg','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',1,'航天一班',0,'764676',0,31,0,'',0,1000),(73,1,'17701804036','00b7691d86d96aebd21dd9e138f90840','17701804875','欧阳疯','public/guest/upload/photo/17701804875/17701804875head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',2,'航天二班',0,'7657',0,31,0,'',0,0),(74,1,'17701804037','00b7691d86d96aebd21dd9e138f90840','17701804878','张大伟','public/guest/upload/photo/17701804878/17701804878head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',3,'二班',0,'7654677',0,31,0,'',0,0),(75,1,'18600000038','4297f44b13955235245b2497399d7a93','18600000009','吕子乔','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',4,'二班',0,'76456',0,31,0,'',0,0),(76,1,'17701804039','e10adc3949ba59abbe56e057f20f883e','齐平','段齐平','public/guest/upload/photo/17701804876/17701804876head.png','pksanwei@163.com',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',1,'信息一班',0,'11432',0,31,0,'',0,0),(77,1,'17701804040','00b7691d86d96aebd21dd9e138f90840','段齐平22','张三','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',2,'信息二班',0,'43214',0,31,0,'',0,0),(78,1,'18600000041','4297f44b13955235245b2497399d7a93','18600000000','王五','public/guest/upload/photo/18600000000/18600000000head.jpg','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'美术系',3,'信息二班',0,'745676',0,31,0,'',0,0),(79,1,'18600000042','e10adc3949ba59abbe56e057f20f883e','18600000001','李四','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',4,'航天一班',0,'7676',0,31,0,'',0,0),(80,1,'18600000043','4297f44b13955235245b2497399d7a93','18600000003','上官云','public/guest/upload/photo/18600000003/18600000003head.jpg','',0,'',2,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',1,'航天一班',0,'764676',0,31,0,'',0,0),(81,1,'17701804044','00b7691d86d96aebd21dd9e138f90840','17701804875','欧阳疯','public/guest/upload/photo/17701804875/17701804875head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'物理系',2,'航天二班',0,'7657',0,31,0,'',0,0),(82,1,'17701804045','00b7691d86d96aebd21dd9e138f90840','17701804878','张大伟','public/guest/upload/photo/17701804878/17701804878head.png','',0,'',1,0,0,1502872365,'上海交通大学(闵行校区)',0,'数学系',3,'二班',0,'7654677',0,31,0,'',0,0),(83,1,'18600000046','4297f44b13955235245b2497399d7a93','18600000009','吕子乔11','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'华东师范大学(普陀校区)',0,'生物系',4,'生物一班',0,'0',0,32,0,'',0,0),(84,1,'17701804047','e10adc3949ba59abbe56e057f20f883e','齐平','段齐平22','public/guest/upload/photo/17701804876/17701804876head.png','pksanwei@163.com',0,'',1,0,0,1502872365,'华东师范大学(普陀校区)',0,'生物系',1,'生物一班',0,'111111111',0,32,0,'',0,0),(85,1,'17701804048','00b7691d86d96aebd21dd9e138f90840','段齐平22','张三33','public/guest/upload/photo/17701804876/17701804876head.png','',0,'',1,0,0,1502872365,'华东师范大学(普陀校区)',0,'化学系',2,'化学10班',0,'333333333',0,32,0,'',0,0),(86,1,'0','','','王大锤','','',0,'',1,0,0,1502872370,'上海交通大学(闵行校区)',0,'物理系',1,'信息一班',0,'2147483647',0,31,0,'',0,0),(87,1,'0','','','李大山','','',0,'',1,0,0,1502872571,'上海交通大学(闵行校区)',0,'物理系',1,'信息一班',0,'2017005468',0,31,0,'',0,0);

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
