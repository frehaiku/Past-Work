-- Adminer 4.0.3 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '+08:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `huizhougzs` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `huizhougzs`;

DROP TABLE IF EXISTS `bottle`;
CREATE TABLE `bottle` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `CONTENT` varchar(150) NOT NULL,
  `PEOPLEID` varchar(50) NOT NULL,
  `peoplenick` varchar(50) NOT NULL,
  `parentid` int(11) NOT NULL DEFAULT '0',
  `duifangid` varchar(50) NOT NULL DEFAULT '0',
  `isread` varchar(50) NOT NULL DEFAULT '0',
  `cishu` int(4) NOT NULL,
  `peopleschool` varchar(50) NOT NULL,
  `CREATE_TIME` varchar(50) NOT NULL,
  `zancount` int(11) DEFAULT '0',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USERID` varchar(32) DEFAULT NULL,
  `NAME` varchar(20) DEFAULT NULL,
  `SCHOOL` varchar(20) DEFAULT NULL,
  `SEX` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- 2017-02-25 12:40:47
