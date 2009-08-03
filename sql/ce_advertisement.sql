-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 07 月 30 日 10:02
-- 服务器版本: 5.0.51
-- PHP 版本: 5.2.6

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
-- 表的结构 `ce_advertisement`
--

CREATE TABLE `ce_advertisement` (
  `adver_id` int(10) unsigned NOT NULL auto_increment COMMENT '广告号',
  `store_id` int(10) unsigned NOT NULL COMMENT '商店号',
  `info` varchar(255) default NULL COMMENT '文字内容|图片名称',
  `time` datetime default NULL COMMENT '发布时间',
  `ad_ftype` varchar(2) NOT NULL COMMENT '小商店|超市|',
  `ad_type` varchar(2) NOT NULL COMMENT '图片|文字',
  PRIMARY KEY  (`adver_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `ce_advertisement`
--

