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
-- 表的结构 `cms_category`
-- 

CREATE TABLE `cms_category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '1',
  `order` int(11) NOT NULL,
  `access` tinyint(3) unsigned NOT NULL default '1',
  `sectionid` int(10) unsigned NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- 
-- 导出表中的数据 `cms_category`
-- 

INSERT INTO `cms_category` VALUES (1, '内地新闻', 'chinanews', '内地新闻', 1, 0, 1, 1, '内地新闻');
INSERT INTO `cms_category` VALUES (2, '港澳新闻', 'HKnews', '', 1, 0, 1, 1, '');
INSERT INTO `cms_category` VALUES (3, '台湾新闻', 'Taiwannews', '', 1, 0, 1, 1, '');
INSERT INTO `cms_category` VALUES (4, '国际新闻', 'internationnews', '', 1, 0, 1, 1, '');
INSERT INTO `cms_category` VALUES (5, '美国新闻', 'usanews', '', 1, 0, 1, 1, '');
INSERT INTO `cms_category` VALUES (6, '日本新闻', 'jpnews', '', 1, 0, 1, 1, '');
