-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2013 年 01 月 26 日 06:30
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `thinkphp`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `cms_section`
-- 

CREATE TABLE `cms_section` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '1',
  `order` int(11) NOT NULL default '0',
  `access` tinyint(3) NOT NULL default '1',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

-- 
-- 导出表中的数据 `cms_section`
-- 

INSERT INTO `cms_section` VALUES (1, '新闻', 'news', '', 1, 0, 1, '');
INSERT INTO `cms_section` VALUES (2, '经济', 'economy', '', 1, 0, 1, '');
INSERT INTO `cms_section` VALUES (3, '综艺', 'Arts', '', 1, 0, 1, '');
INSERT INTO `cms_section` VALUES (4, '微博', 'blog', '', 1, 0, 1, '');
INSERT INTO `cms_section` VALUES (5, '游戏', 'game', '', 1, 0, 1, '');
INSERT INTO `cms_section` VALUES (6, '评论', 'discuss', '', 1, 0, 1, '');
INSERT INTO `cms_section` VALUES (7, '体育', 'sports', '', 1, 0, 1, '');
INSERT INTO `cms_section` VALUES (8, '科教', 'Technology', '', 1, 0, 1, '');
INSERT INTO `cms_section` VALUES (9, '产经', 'industry', '', 1, 0, 1, '');
INSERT INTO `cms_section` VALUES (10, '电影', 'movie', '', 1, 0, 1, '');
INSERT INTO `cms_section` VALUES (12, 'IT', 'IT', '', 1, 0, 1, '');
