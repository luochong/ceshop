-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 07 月 31 日 00:43
-- 服务器版本: 5.1.30
-- PHP 版本: 5.2.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `ceshop`
--

-- --------------------------------------------------------

--
-- 表的结构 `ce_smallstore`
--

CREATE TABLE IF NOT EXISTS `ce_smallstore` (
  `store_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '小商店ID',
  `type_id` int(10) unsigned NOT NULL COMMENT '类型ID',
  `storename` char(20) DEFAULT NULL COMMENT '商店名称',
  `logo` varchar(50) NOT NULL,
  `picture` varchar(50) DEFAULT NULL COMMENT '图片',
  `boss` char(8) DEFAULT NULL COMMENT '负责人',
  `tel` char(10) DEFAULT NULL COMMENT '座机',
  `mobile` char(15) DEFAULT NULL COMMENT '手机',
  `qq` char(15) DEFAULT NULL COMMENT 'QQ号码',
  `email` char(20) DEFAULT NULL COMMENT '电子邮件',
  `storeinfo` text COMMENT '商店介绍',
  `address` char(50) DEFAULT NULL COMMENT '地址',
  `area` int(10) unsigned DEFAULT NULL COMMENT '面积',
  `ismeal` tinyint(1) DEFAULT '0' COMMENT '是否订餐',
  `score` int(10) unsigned DEFAULT NULL COMMENT '积分',
  PRIMARY KEY (`store_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;

--
-- 导出表中的数据 `ce_smallstore`
--

