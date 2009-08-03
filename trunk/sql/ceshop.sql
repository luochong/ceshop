-- phpMyAdmin SQL Dump
-- version 2.11.6
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2009 年 08 月 03 日 05:58
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
  `ad_url` varchar(255) NOT NULL,
  `sort` int(4) NOT NULL,
  PRIMARY KEY  (`adver_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 导出表中的数据 `ce_advertisement`
--

INSERT INTO `ce_advertisement` (`adver_id`, `store_id`, `info`, `time`, `ad_ftype`, `ad_type`, `ad_url`, `sort`) VALUES
(1, 46, 'test.jpg', '2009-07-31 15:52:52', '0', '0', 'no', 3),
(2, 0, 'test', NULL, '0', '1', 'test.php', 2),
(3, 7, '29594a72ae531c698.jpg', NULL, '1', '0', '123', 2),
(4, 7, 'test', NULL, '1', '1', 'test', 2),
(5, 5, 'test2', NULL, '1', '1', 'test2', 1);

-- --------------------------------------------------------

--
-- 表的结构 `ce_brand`
--

CREATE TABLE `ce_brand` (
  `brand_id` int(10) unsigned NOT NULL auto_increment,
  `brand_name` varchar(30) default NULL,
  `brand_logo` varchar(60) default NULL,
  `brand_website` varchar(60) default NULL,
  PRIMARY KEY  (`brand_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `ce_brand`
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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- 导出表中的数据 `ce_category_attribute`
--

INSERT INTO `ce_category_attribute` (`attribute_id`, `category_id`, `attribute_name`, `attribute_type`, `attribute_value`) VALUES
(1, 1, '出版社', 'enum', '北京大学出版社|湖南大学出版社'),
(2, 1, '出版社4', 'enum', '北京大学出版社|湖南大学出版社'),
(3, 9, '尺寸', 'enum', '155/80---XXS--特小号| 160/85---XS---加小号| 165/90---S----小号| 170/95---M----中号| 175/100--L----大号| 180/105--XL---加大号 |185/110--XXL---特大号| 190/115--XXXL---特大号'),
(4, 1, '出版时间', 'date', ''),
(5, 1, '作者', 'text', ''),
(6, 9, '颜色', 'enum', '红|黄'),
(7, 9, '生产日期', 'date', ''),
(8, 2, 'php等级', 'enum', '一级|二级');

-- --------------------------------------------------------

--
-- 表的结构 `ce_cgoods`
--

CREATE TABLE `ce_cgoods` (
  `cgoods_id` int(10) NOT NULL auto_increment,
  `category_id` int(10) default NULL,
  `user_id` int(10) default NULL,
  `goods_name` varchar(60) default NULL,
  `cgoods_rating` int(10) default NULL,
  `cgoods_Intro` text,
  `cgoods_type` tinyint(4) default NULL,
  `publish_time` datetime default NULL,
  `big_img` varchar(60) default NULL,
  `small_img` varchar(60) default NULL,
  `photo_sn` varchar(60) default NULL,
  `is_auction` tinyint(4) default NULL,
  `auction_price` decimal(6,3) default NULL,
  `cgoods_price` decimal(6,3) default NULL,
  PRIMARY KEY  (`cgoods_id`),
  KEY `FK_Relationship_10` (`user_id`),
  KEY `FK_Relationship_9` (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `ce_cgoods`
--


-- --------------------------------------------------------

--
-- 表的结构 `ce_cgoods_attention`
--

CREATE TABLE `ce_cgoods_attention` (
  `cgoods_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL default '0',
  `attention_type` int(10) default NULL,
  `attention_time` datetime default NULL,
  PRIMARY KEY  (`cgoods_id`,`user_id`),
  KEY `FK_Relationship_11` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `ce_cgoods_attention`
--


-- --------------------------------------------------------

--
-- 表的结构 `ce_comment`
--

CREATE TABLE `ce_comment` (
  `comment_id` int(10) unsigned NOT NULL auto_increment,
  `user_id` int(10) unsigned default NULL,
  `from_id` int(10) unsigned default NULL,
  `from_type` varchar(6) default NULL,
  `comment_content` text,
  `support_no` int(8) unsigned default NULL,
  `fight_no` int(10) unsigned default NULL,
  `is_report` int(5) unsigned default NULL,
  `publish_time` datetime default NULL,
  `far_id` int(10) unsigned NOT NULL,
  `user_name` varchar(10) NOT NULL,
  `re_no` int(5) unsigned NOT NULL,
  PRIMARY KEY  (`comment_id`),
  KEY `FK_Relationship_13` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- 导出表中的数据 `ce_comment`
--

INSERT INTO `ce_comment` (`comment_id`, `user_id`, `from_id`, `from_type`, `comment_content`, `support_no`, `fight_no`, `is_report`, `publish_time`, `far_id`, `user_name`, `re_no`) VALUES
(1, 2, 2, 'goods', 'goods', 1, 9, 0, '2009-08-01 13:45:07', 0, 'lc', 0),
(2, 2, 3, 'goods', 'goods', 4, 5, 0, '2009-08-01 13:46:11', 0, 'lc', 0),
(3, 1, 2, 'goods', 'a', 0, 0, 0, '2009-08-01 16:02:50', 0, 'lc', 0),
(4, 1, 2, 'goods', '1', 0, 0, 0, '2009-08-01 16:02:52', 0, 'lc', 0),
(5, 1, 2, 'goods', '1', 0, 0, 0, '2009-08-01 16:02:55', 0, 'lc', 0),
(6, 1, 2, 'goods', '1', 0, 0, 0, '2009-08-01 16:05:33', 0, 'lc', 0),
(7, 1, 2, 'goods', '12123', 0, 0, 0, '2009-08-01 16:05:37', 0, 'lc', 0),
(8, 1, 2, 'goods', '123123', 0, 0, 0, '2009-08-01 16:05:38', 0, 'lc', 0),
(9, 1, 2, 'goods', '123123', 0, 0, 0, '2009-08-01 16:07:07', 0, 'lc', 0),
(10, 1, 2, 'goods', '1213', 0, 0, 0, '2009-08-01 16:07:10', 0, 'lc', 0),
(11, 1, 2, 'goods', '123', 0, 0, 0, '2009-08-01 17:31:31', 0, 'lc', 0),
(12, 1, 2, 'goods', '487456', 0, 0, 0, '2009-08-01 17:31:37', 0, 'lc', 0);

-- --------------------------------------------------------

--
-- 表的结构 `ce_demo`
--

CREATE TABLE `ce_demo` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(12) character set utf8 NOT NULL,
  `content` text character set utf8 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- 导出表中的数据 `ce_demo`
--

INSERT INTO `ce_demo` (`id`, `name`, `content`) VALUES
(2, '罗崇', '例子......'),
(3, 'luochong', 'test'),
(4, 'test', 'test'),
(5, 'test', 'test'),
(6, 'test', 'test'),
(7, 'test', 'test'),
(8, 'test', 'test'),
(9, 'test', 'test'),
(10, 'test', 'test'),
(11, 'test', 'test'),
(12, '&lt;h1&gt;te', '&lt;h1&gt;test&lt;/h1&gt;');

-- --------------------------------------------------------

--
-- 表的结构 `ce_dishes`
--

CREATE TABLE `ce_dishes` (
  `dish_id` int(11) unsigned NOT NULL auto_increment COMMENT '菜肴号',
  `DName` char(12) NOT NULL COMMENT '菜名',
  `DPic` varchar(50) default NULL COMMENT '图片',
  PRIMARY KEY  (`dish_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='菜肴表' AUTO_INCREMENT=43 ;

--
-- 导出表中的数据 `ce_dishes`
--


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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 导出表中的数据 `ce_goods`
--

INSERT INTO `ce_goods` (`goods_id`, `category_id`, `goods_sn`, `parent_id`, `goods_quantity`, `goods_weight`, `store_id`, `brand_id`, `market_price`, `shop_price`, `is_promotion`, `is_discount`, `is_best`, `goods_discount`, `up_time`, `goods_rating`, `promote_price`, `promotion_stime`, `Promotion_etime`, `small_img`, `big_img`, `photo_sn`, `slide_img`, `goods_Intro`, `goods_name`) VALUES
(1, 2, 'DS001', NULL, 10, 100, 6, 0, '200.00', '180.00', 1, NULL, 1, '0.00', NULL, NULL, '175.00', '2009-07-02', '2009-07-27', 'small62984a6ebe24739781.jpg', '62984a6ebe24739781.jpg', NULL, NULL, '', '超级被子'),
(2, 1, 'DES002', 0, 20, 20, 6, 0, '109.00', '100.00', 0, 0, 1, '0.00', NULL, NULL, '0.00', '0000-00-00', '0000-00-00', 'small212824a6ebe30b29161.jpg', '212824a6ebe30b29161.jpg', NULL, NULL, '', 'php权威编程'),
(3, 2, 'DES0005', 0, 8, 10, 6, 0, '100.00', '100.00', 0, 0, 1, '0.00', NULL, NULL, '0.00', '0000-00-00', '0000-00-00', 'small182494a6ebe39e49761.jpg', '182494a6ebe39e49761.jpg', NULL, NULL, '1', '图书'),
(4, 1, 'DES0012', 0, 10, 100, 6, 0, '10.00', '10.00', 0, 0, 0, '0.00', NULL, NULL, '0.00', '0000-00-00', '0000-00-00', 'small4304a6ebe4370a5b1.jpg', '4304a6ebe4370a5b1.jpg', NULL, NULL, '流氓兔', '流氓兔'),
(9, 2, 'CE00000005', 0, 1, 1, 5, 0, '1.00', '1.00', 0, 0, 1, '0.00', NULL, NULL, '0.00', '0000-00-00', '0000-00-00', 'small324044a7151288288f1.jpg', '324044a7151288288f1.jpg', NULL, NULL, '1', 'php网络编程');

-- --------------------------------------------------------

--
-- 表的结构 `ce_goodsinfo`
--

CREATE TABLE `ce_goodsinfo` (
  `goodsinfo_id` int(10) unsigned NOT NULL auto_increment,
  `store_id` int(10) unsigned NOT NULL,
  `type_id` int(10) unsigned NOT NULL,
  `goodsname` char(20) default NULL,
  `price` decimal(8,2) unsigned default NULL,
  `info` text,
  `picture` varchar(50) default NULL,
  `logo` varchar(50) default NULL,
  `score` int(10) unsigned default NULL,
  `sort` int(11) default NULL,
  PRIMARY KEY  (`goodsinfo_id`),
  KEY `store_id` (`store_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品信息' AUTO_INCREMENT=5 ;

--
-- 导出表中的数据 `ce_goodsinfo`
--


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
(1, 2, '1', '机械工业出版社');

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

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
(9, NULL, 0, '衣服', NULL, NULL, 0, 0, 1),
(10, NULL, 0, '速食', NULL, NULL, 0, 0, 1),
(11, NULL, 0, '水果', NULL, NULL, 0, 0, 1),
(12, NULL, 11, '苹果', NULL, NULL, 0, 0, 1),
(13, NULL, 11, '香蕉', NULL, NULL, 0, 0, 1),
(14, NULL, 11, '西瓜', NULL, NULL, 0, 0, 1);

-- --------------------------------------------------------

--
-- 表的结构 `ce_order`
--

CREATE TABLE `ce_order` (
  `order_id` int(10) NOT NULL auto_increment,
  `user_id` int(10) default NULL,
  `user_name` varchar(8) default NULL,
  `user_sex` varchar(2) default NULL,
  `user_mobile` varchar(13) default NULL,
  `user_address` varchar(255) default NULL,
  `order_pay` decimal(6,3) default NULL,
  `order_state` int(10) default NULL,
  `publish_time` datetime default NULL,
  `store_id` int(10) default NULL,
  PRIMARY KEY  (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `ce_order`
--


-- --------------------------------------------------------

--
-- 表的结构 `ce_order_goods`
--

CREATE TABLE `ce_order_goods` (
  `goods_id` int(10) NOT NULL default '0',
  `order_id` int(10) NOT NULL default '0',
  `goods_sn` varchar(60) default NULL,
  `goods_name` varchar(60) default NULL,
  `goods_price` decimal(6,3) default NULL,
  `goods_info` text,
  PRIMARY KEY  (`goods_id`,`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `ce_order_goods`
--


-- --------------------------------------------------------

--
-- 表的结构 `ce_other_info`
--

CREATE TABLE `ce_other_info` (
  `info_id` int(10) NOT NULL auto_increment,
  `goods_sn` varchar(60) default NULL,
  `info_key` varchar(60) default NULL,
  `info_value` varchar(60) default NULL,
  `attention_type` int(10) default NULL,
  PRIMARY KEY  (`info_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `ce_other_info`
--


-- --------------------------------------------------------

--
-- 表的结构 `ce_post`
--

CREATE TABLE `ce_post` (
  `post_id` int(10) NOT NULL auto_increment,
  `type_id` int(10) default NULL,
  `comment_content` text,
  `publish_time` datetime default NULL,
  `post_title` varchar(255) default NULL,
  `post_key` varchar(60) default NULL,
  `post_state` tinyint(4) default NULL,
  `store_id` int(10) default NULL,
  PRIMARY KEY  (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `ce_post`
--


-- --------------------------------------------------------

--
-- 表的结构 `ce_post_type`
--

CREATE TABLE `ce_post_type` (
  `type_id` int(10) NOT NULL auto_increment,
  `category_name` varchar(60) default NULL,
  PRIMARY KEY  (`type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `ce_post_type`
--


-- --------------------------------------------------------

--
-- 表的结构 `ce_smallstore`
--

CREATE TABLE `ce_smallstore` (
  `store_id` int(10) unsigned NOT NULL auto_increment COMMENT '小商店ID',
  `type_id` int(10) unsigned NOT NULL COMMENT '类型ID',
  `storename` char(20) default NULL COMMENT '商店名称',
  `logo` varchar(50) NOT NULL,
  `picture` varchar(50) default NULL COMMENT '图片',
  `boss` char(8) default NULL COMMENT '负责人',
  `tel` char(10) default NULL COMMENT '座机',
  `mobile` char(15) default NULL COMMENT '手机',
  `qq` char(15) default NULL COMMENT 'QQ号码',
  `email` char(20) default NULL COMMENT '电子邮件',
  `storeinfo` text COMMENT '商店介绍',
  `address` char(50) default NULL COMMENT '地址',
  `area` int(10) unsigned default NULL COMMENT '面积',
  `ismeal` tinyint(1) default '0' COMMENT '是否订餐',
  `score` int(10) unsigned default NULL COMMENT '积分',
  PRIMARY KEY  (`store_id`),
  KEY `type_id` (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=47 ;

--
-- 导出表中的数据 `ce_smallstore`
--

INSERT INTO `ce_smallstore` (`store_id`, `type_id`, `storename`, `logo`, `picture`, `boss`, `tel`, `mobile`, `qq`, `email`, `storeinfo`, `address`, `area`, `ismeal`, `score`) VALUES
(46, 73, '月儿服饰', '', '185914a72662f9c26e.jpg', 'QQ', '8312863', '123456', '65771534', '65771534@qq.com', '月儿服饰', '红旗', 20, 0, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `ce_smallstore_type`
--

CREATE TABLE `ce_smallstore_type` (
  `type_id` int(10) unsigned NOT NULL auto_increment COMMENT '类型编号',
  `typename` char(10) NOT NULL COMMENT '类型名',
  PRIMARY KEY  (`type_id`),
  UNIQUE KEY `type_name` (`typename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='商家类型' AUTO_INCREMENT=74 ;

--
-- 导出表中的数据 `ce_smallstore_type`
--

INSERT INTO `ce_smallstore_type` (`type_id`, `typename`) VALUES
(73, '服饰');

-- --------------------------------------------------------

--
-- 表的结构 `ce_store`
--

CREATE TABLE `ce_store` (
  `store_id` int(10) NOT NULL auto_increment,
  `store_name` varchar(60) default NULL,
  `store_account` varchar(20) default NULL,
  `store_password` varchar(16) default NULL,
  `store_logo` varchar(50) default NULL,
  `store_info` text,
  PRIMARY KEY  (`store_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- 导出表中的数据 `ce_store`
--

INSERT INTO `ce_store` (`store_id`, `store_name`, `store_account`, `store_password`, `store_logo`, `store_info`) VALUES
(7, '奥尔玛', 'lc', 'lc', 'storelogo159844a70084d898da.jpg', '奥尔玛'),
(6, '家润多', '123', '123', 'storelogo229604a7009b3e9916.jpg', '家润多'),
(5, '大润发', 'lc', 'lc', 'storelogo16554a7009cecf098.jpg', '大润发'),
(8, 'sfasdasf', 's', 's', 'storelogo224664a73f35425c4b.jpg', 's'),
(9, '12', '123', '123', 'storelogo280324a73f2db7da25.jpg', '123');

-- --------------------------------------------------------

--
-- 表的结构 `ce_s_d`
--

CREATE TABLE `ce_s_d` (
  `store_id` int(10) unsigned NOT NULL auto_increment COMMENT '商店编号',
  `dish_id` int(10) unsigned NOT NULL COMMENT '菜肴编号',
  `price` int(11) default NULL COMMENT '售价',
  `ishot` tinyint(1) default '0' COMMENT '是否热卖',
  `isnew` tinyint(1) default '0' COMMENT '是否新上市',
  PRIMARY KEY  (`store_id`,`dish_id`),
  KEY `dish_id` (`dish_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 导出表中的数据 `ce_s_d`
--


-- --------------------------------------------------------

--
-- 表的结构 `ce_user`
--

CREATE TABLE `ce_user` (
  `user_id` int(10) NOT NULL,
  `user_mobile` varchar(13) default NULL,
  `user_address` varchar(255) default NULL,
  `user_name` varchar(8) default NULL,
  `user_password` varchar(60) default NULL,
  `user_cno` int(11) default NULL,
  `user_dno` int(11) default NULL,
  `user_gno` int(11) default NULL,
  `user_qq` varchar(12) default NULL,
  `user_email` varchar(60) default NULL,
  `user_sex` varchar(2) default NULL,
  PRIMARY KEY  (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 导出表中的数据 `ce_user`
--

