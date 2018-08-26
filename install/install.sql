-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 
-- 服务器版本: 5.5.53
-- PHP 版本: 7.2.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `kmxt`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text NOT NULL,
  `passwords` text NOT NULL,
  `gqtime` int(11) NOT NULL,
  `zfbimg` text NOT NULL,
  `wximg` text NOT NULL,
  `qqimg` text NOT NULL,
  `appid` varchar(32) NOT NULL,
  `apppwd` varchar(32) NOT NULL,
  `mailu` varchar(255) NOT NULL,
  `mailp` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `passwords`, `gqtime`, `zfbimg`, `wximg`, `qqimg`, `appid`, `apppwd`, `mailu`, `mailp`) VALUES
(1, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 3, 'https://b.alipay.com/settling/tc/entry.htm', 'https://jingyan.baidu.com/article/5bbb5a1b05176c13eba179d8.html', 'https://zhidao.baidu.com/question/685945950783168332.html', '', '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `aqzy`
--

CREATE TABLE IF NOT EXISTS `aqzy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `zfb` text NOT NULL COMMENT '支付宝验证',
  `wx` text NOT NULL,
  `qq` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='验证服务器是否运行' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `aqzy`
--

INSERT INTO `aqzy` (`id`, `zfb`, `wx`, `qq`) VALUES
(1, 'stop', 'stop', 'stop');

-- --------------------------------------------------------

--
-- 表的结构 `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `title` text NOT NULL COMMENT '标题',
  `tail` text NOT NULL COMMENT '标题尾巴',
  `keywords` text NOT NULL COMMENT '关键词',
  `description` text NOT NULL COMMENT '简介',
  `gg` text NOT NULL COMMENT '网站公告',
  `background` text,
  `copyright` text NOT NULL COMMENT '版权',
  `qq` text NOT NULL COMMENT 'qq',
  `dhat` varchar(255) NOT NULL,
  `dhah` varchar(255) NOT NULL,
  `dhbt` varchar(255) NOT NULL,
  `dhbh` varchar(255) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='网站配置' AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `config`
--

INSERT INTO `config` (`title`, `tail`, `keywords`, `description`, `gg`, `background`, `copyright`, `qq`, `dhat`, `dhah`, `dhbt`, `dhbh`, `id`) VALUES
('EDLM自助提卡系统', '商业版3.1', '自助提卡,卡密,商业版3.1', 'EDLM自助提卡系统是由E帝联盟-创始人Md,独自开发的一个站长收款免签约自助提卡系统,安全、稳定、不加收任何费用、直接到账、一站式售卡系统。', '欢迎使用自助提卡系统3.1商业版 官网:<a href="http://km.edlm.cn/">km.edlm.cn</a>', '', 'Copyright &copy; <a href="http://www.edlm.cn/">EDLM</a>-Md All Rights Reserved', '10000', '首页', '', 'L Pays', 'http://lp.edlm.cn/', 1);

-- --------------------------------------------------------

--
-- 表的结构 `gg`
--

CREATE TABLE IF NOT EXISTS `gg` (
  `tta` text NOT NULL COMMENT '广告a图片',
  `lla` text NOT NULL COMMENT '广告a链接',
  `ttb` text NOT NULL,
  `llb` text NOT NULL,
  `ttc` text NOT NULL,
  `llc` text NOT NULL,
  `yya` text NOT NULL COMMENT '广告A语',
  `yyb` text NOT NULL,
  `yyc` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `gg`
--

INSERT INTO `gg` (`tta`, `lla`, `ttb`, `llb`, `ttc`, `llc`, `yya`, `yyb`, `yyc`, `id`) VALUES
('http://cdn.edlm.cn/images/lp.jpg', 'http://lp.edlm.cn/', '', '', '', '', '有一款免签约API，等待你的签收!', '', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `kms`
--

CREATE TABLE IF NOT EXISTS `kms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL COMMENT '卡密名称(名称分类)',
  `dh` text NOT NULL COMMENT '购买订单号',
  `km` text NOT NULL COMMENT '卡密',
  `time` text NOT NULL COMMENT '购买时间',
  `mode` text NOT NULL COMMENT '支付方式',
  `spid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='卡密数据' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lists`
--

CREATE TABLE IF NOT EXISTS `lists` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL COMMENT '商品名字',
  `mode` text NOT NULL COMMENT '商品说明',
  `money` text NOT NULL COMMENT '商品价格',
  `type` text NOT NULL,
  `spid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商品列表' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `lpays`
--

CREATE TABLE IF NOT EXISTS `lpays` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `dh` varchar(18) NOT NULL,
  `pwd` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `qq`
--

CREATE TABLE IF NOT EXISTS `qq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dh` text NOT NULL COMMENT '单号',
  `title` text NOT NULL COMMENT '名称',
  `income` text NOT NULL COMMENT '收入',
  `time` int(11) NOT NULL COMMENT '时间',
  `gqtime` int(11) NOT NULL COMMENT '到期时间',
  `pwd` text NOT NULL COMMENT '联系方式',
  `ip` text NOT NULL,
  `spid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='qq收款数据' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `type`
--

CREATE TABLE IF NOT EXISTS `type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `tid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `wx`
--

CREATE TABLE IF NOT EXISTS `wx` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dh` text NOT NULL COMMENT '单号',
  `title` text NOT NULL COMMENT '名称',
  `income` text NOT NULL COMMENT '收入',
  `time` int(11) NOT NULL COMMENT '时间',
  `gqtime` int(11) NOT NULL COMMENT '到期时间',
  `pwd` text NOT NULL COMMENT '联系方式',
  `ip` text NOT NULL,
  `spid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='微信收款数据' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- 表的结构 `zfb`
--

CREATE TABLE IF NOT EXISTS `zfb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dh` text NOT NULL COMMENT '流水号',
  `title` text NOT NULL COMMENT '商品名称',
  `income` text NOT NULL COMMENT '收入',
  `time` int(11) NOT NULL COMMENT '提交时间',
  `gqtime` int(11) NOT NULL COMMENT '到期时间',
  `pwd` text NOT NULL COMMENT '联系方式',
  `ip` text NOT NULL,
  `spid` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付宝数据' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
