-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 07 月 28 日 09:08
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
-- 表的结构 `ce_category_attribute`
--

CREATE TABLE `ce_category_attribute` (
  `attribute_id` int(10) NOT NULL auto_increment,
  `category_id` int(10) default NULL,
  `attribute_name` varchar(40) default NULL,
  `attribute_type` varchar(8) default NULL,
  `attribute_value` varchar(255) default NULL,
  PRIMARY KEY  (`attribute_id`),
  KEY `FK_Relationship_1` (`category_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 导出表中的数据 `ce_category_attribute`
--

INSERT INTO `ce_category_attribute` (`attribute_id`, `category_id`, `attribute_name`, `attribute_type`, `attribute_value`) VALUES
(1, 1, '出版社', 'enum', '北京大学出版社|湖南大学出版社'),
(2, 1, '出版社4', 'enum', '北京大学出版社|湖南大学出版社'),
(3, 9, '尺寸', 'enum', '155/80---XXS--特小号| 160/85---XS---加小号| 165/90---S----小号| 170/95---M----中号| 175/100--L----大号| 180/105--XL---加大号 |185/110--XXL---特大号| 190/115--XXXL---特大号'),
(4, 1, '出版时间', 'date', ''),
(5, 1, '作者', 'text', '');

-- --------------------------------------------------------

--
-- 表的结构 `ce_goods`
--

CREATE TABLE `ce_goods` (
  `goods_id` int(10) NOT NULL auto_increment,
  `category_id` int(10) default NULL,
  `goods_sn` varchar(60) default NULL,
  `parent_id` int(10) default '0',
  `goods_quantity` int(10) default NULL,
  `goods_weight` int(10) default NULL,
  `store_id` int(10) default NULL,
  `brand_id` int(10) default NULL,
  `market_price` decimal(8,2) default NULL,
  `shop_price` decimal(8,2) default NULL,
  `is_promotion` tinyint(4) default '0',
  `is_discount` tinyint(4) default '0',
  `is_best` tinyint(4) default '0',
  `goods_discount` decimal(2,2) default NULL,
  `up_time` datetime default NULL,
  `goods_rating` int(10) default NULL,
  `promote_price` decimal(8,2) default NULL,
  `promotion_stime` date default NULL,
  `Promotion_etime` date default NULL,
  `small_img` varchar(60) default NULL,
  `big_img` varchar(60) default NULL,
  `photo_sn` varchar(60) default NULL,
  `slide_img` varchar(60) default NULL,
  `goods_Intro` text,
  `goods_name` varchar(60) default NULL,
  PRIMARY KEY  (`goods_id`),
  UNIQUE KEY `goods_sn` (`goods_sn`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- 导出表中的数据 `ce_goods`
--

INSERT INTO `ce_goods` (`goods_id`, `category_id`, `goods_sn`, `parent_id`, `goods_quantity`, `goods_weight`, `store_id`, `brand_id`, `market_price`, `shop_price`, `is_promotion`, `is_discount`, `is_best`, `goods_discount`, `up_time`, `goods_rating`, `promote_price`, `promotion_stime`, `Promotion_etime`, `small_img`, `big_img`, `photo_sn`, `slide_img`, `goods_Intro`, `goods_name`) VALUES
(1, 0, 'DS001', NULL, 10, 100, 6, 0, '200.00', '180.00', 1, NULL, 1, '0.00', NULL, NULL, '175.00', '2009-07-02', '2009-07-27', 'small62984a6ebe24739781.jpg', '62984a6ebe24739781.jpg', NULL, NULL, '', '超级被子'),
(2, 1, 'DES002', 0, 20, 20, 6, 0, '109.00', '100.00', 0, 0, 1, '0.00', NULL, NULL, '0.00', '0000-00-00', '0000-00-00', 'small212824a6ebe30b29161.jpg', '212824a6ebe30b29161.jpg', NULL, NULL, '', 'php权威编程'),
(3, 2, 'DES0005', 0, 8, 10, 6, 0, '100.00', '100.00', 0, 0, 0, '0.00', NULL, NULL, '0.00', '0000-00-00', '0000-00-00', 'small182494a6ebe39e49761.jpg', '182494a6ebe39e49761.jpg', NULL, NULL, '1', '图书'),
(4, 1, 'DES0012', 0, 10, 100, 6, 0, '10.00', '10.00', 0, 0, 0, '0.00', NULL, NULL, '0.00', '0000-00-00', '0000-00-00', 'small4304a6ebe4370a5b1.jpg', '4304a6ebe4370a5b1.jpg', NULL, NULL, '流氓兔', '流氓兔'),
(5, 1, 'N70', 0, 10, 10, 6, 0, '20000.00', '20000.00', 0, 0, 1, '0.00', NULL, NULL, '0.00', '0000-00-00', '0000-00-00', 'small274604a6e9481e647a1.jpg', '274604a6e9481e647a1.jpg', '197954a6e72c1dd966.jpg', NULL, '诺基亚N70', '诺基亚N70'),
(6, 1, 'DE2007', 0, 10, 10, 6, 0, '10.00', '10.00', 0, 0, 1, '0.00', NULL, NULL, '0.00', '0000-00-00', '0000-00-00', 'small260374a6ebe5046e221.jpg', '260374a6ebe5046e221.jpg', NULL, NULL, 'JavaScript', 'JavaScript'),
(7, 9, 'DES0002', 0, 10, 10, 6, 0, '10.00', '10.00', 0, 0, 1, '0.00', NULL, NULL, '0.00', '0000-00-00', '0000-00-00', 'small29834a6ea13488c8b1.jpg', '29834a6ea13488c8b1.jpg', '147664a6ea1481225b.jpg', NULL, '男士衬衣', '男士衬衣');

-- --------------------------------------------------------

--
-- 表的结构 `ce_goods_attribute`
--

CREATE TABLE `ce_goods_attribute` (
  `attribute_id` int(10) NOT NULL default '0',
  `goods_id` int(10) NOT NULL default '0',
  `goods_type` varchar(2) default '00' COMMENT '商家、客户商品',
  `attribute_value` varchar(255) default NULL,
  PRIMARY KEY  (`attribute_id`,`goods_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `ce_goods_attribute`
--

INSERT INTO `ce_goods_attribute` (`attribute_id`, `goods_id`, `goods_type`, `attribute_value`) VALUES
(1, 2, '1', '机械工业出版社'),
(1, 5, '1', '北京大学出版社'),
(2, 5, '1', '2009-07-01'),
(3, 7, '1', '170/95---M----中号');

-- --------------------------------------------------------

--
-- 表的结构 `ce_goods_category`
--

CREATE TABLE `ce_goods_category` (
  `category_id` int(10) NOT NULL auto_increment,
  `category_img` varchar(30) default NULL,
  `far_id` int(10) default '0',
  `category_name` varchar(60) default NULL,
  `category_sort` int(11) default NULL,
  `add_time` datetime default NULL,
  `category_cno` int(10) default '0',
  `category_no` int(10) default '0',
  `have_attr` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`category_id`),
  UNIQUE KEY `category_name` (`category_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 导出表中的数据 `ce_goods_category`
--

INSERT INTO `ce_goods_category` (`category_id`, `category_img`, `far_id`, `category_name`, `category_sort`, `add_time`, `category_cno`, `category_no`, `have_attr`) VALUES
(1, NULL, 0, '书', NULL, '2009-07-27 11:45:27', 0, 0, 1),
(2, NULL, 1, 'PHP书', NULL, '2009-07-27 14:02:32', 0, 0, 1),
(3, NULL, 2, 'PHP游戏开发', NULL, '2009-07-27 14:05:46', 0, 0, 1),
(4, NULL, 2, 'PHP web开发', NULL, '2009-07-27 14:17:21', 0, 0, 1),
(5, NULL, 0, '手机', NULL, '2009-07-27 14:19:29', 0, 0, 1),
(6, NULL, 2, 'PHP OOP', NULL, NULL, 0, 0, 1),
(9, NULL, 0, '衣服', NULL, NULL, 0, 0, 1);
