-- phpMyAdmin SQL Dump
-- version 3.1.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 07 月 29 日 03:17
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
-- 表的结构 `ce_dishes`
--

CREATE TABLE IF NOT EXISTS `ce_dishes` (
  `dish_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜肴号',
  `DName` char(12) NOT NULL COMMENT '菜名',
  `DPic` varchar(50) DEFAULT NULL COMMENT '图片',
  PRIMARY KEY (`dish_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜肴表' AUTO_INCREMENT=43 ;

--
-- 导出表中的数据 `ce_dishes`
--

