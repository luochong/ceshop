-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 07 月 31 日 03:30
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
-- 表的结构 `ce_smallstore_type`
--

CREATE TABLE IF NOT EXISTS `ce_smallstore_type` (
  `type_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '类型编号',
  `typename` char(10) NOT NULL COMMENT '类型名',
  PRIMARY KEY (`type_id`),
  UNIQUE KEY `type_name` (`typename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商家类型' AUTO_INCREMENT=73 ;

--
-- 导出表中的数据 `ce_smallstore_type`
--

