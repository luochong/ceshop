-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 07 月 31 日 00:31
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
-- 表的结构 `ce_goodsinfo`
--

CREATE TABLE IF NOT EXISTS `ce_goodsinfo` (
  `goodsinfo_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `store_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `goodsname` char(20) DEFAULT NULL,
  `price` int(10) unsigned DEFAULT NULL,
  `info` text,
  `picture` varchar(50) DEFAULT NULL,
  `logo` varchar(50) DEFAULT NULL,
  `score` int(10) unsigned DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`goodsinfo_id`),
  KEY `store_id` (`store_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品信息' AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `ce_goodsinfo`
--

