DROP TABLE IF EXISTS `goodsadmin`;
CREATE TABLE `goodsadmin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `goodsadmin` (`id`, `username`, `password`) VALUES
(0,	'admin',	'adminadmin');

DROP TABLE IF EXISTS `goodsclaims`;
CREATE TABLE `goodsclaims` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `claim` varchar(100) NOT NULL COMMENT '举报人id',
  `claimedzname` varchar(100) NOT NULL COMMENT '被举报人真名',
  `claimed` varchar(100) NOT NULL COMMENT '被举报人id',
  `claimedschool` varchar(100) NOT NULL COMMENT '被举报人学校',
  `claimzname` varchar(100) NOT NULL COMMENT '举报人真名',
  `claimschool` varchar(100) NOT NULL COMMENT '举报人学校',
  `claimcontent` varchar(100) NOT NULL COMMENT '举报内容',
  `recordid` varchar(100) NOT NULL COMMENT '帖子id/评论id',
  `claimstatus` varchar(100) DEFAULT '0' COMMENT '是否已处理',
  `userid` varchar(100) NOT NULL COMMENT '用户id',
  `kind` varchar(100) NOT NULL DEFAULT '0' COMMENT '判断是举报帖子还是举报评论',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `goodscomment`;
CREATE TABLE `goodscomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `detailid` varchar(100) NOT NULL COMMENT '被评论帖子id',
  `commentedid` varchar(100) NOT NULL COMMENT '被评论人id',
  `commentid` varchar(100) NOT NULL COMMENT '评论人id',
  `commentcontent` varchar(100) NOT NULL,
  `commentnname` varchar(100) NOT NULL COMMENT '评论人昵称',
  `deletestatus` varchar(100) NOT NULL DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `goodsdetail`;
CREATE TABLE `goodsdetail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `goodstype` varchar(100) NOT NULL,
  `goodsname` varchar(100) NOT NULL,
  `goodsprice` varchar(100) NOT NULL,
  `contactsname` varchar(100) NOT NULL,
  `contactsphone` varchar(100) NOT NULL,
  `goodsdescribe` varchar(100) NOT NULL,
  `goodsimageurl` varchar(100) NOT NULL,
  `goodstime` varchar(100) NOT NULL,
  `goodsstatus` varchar(10) NOT NULL DEFAULT '1',
  `deletestatus` varchar(10) NOT NULL DEFAULT '0',
  `useropenid` varchar(100) NOT NULL,
  `userschool` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

DROP TABLE IF EXISTS `goodsschool`;
CREATE TABLE `goodsschool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `schoolname` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `goodsschool` (`id`, `schoolname`) VALUES
(1,	'惠州市第一中学'),
(2,	'惠州市第三中学'),
(3,	'惠州市第四中学'),
(4,	'惠州市第八中学'),
(5,	'惠州市东江高级中学'),
(10,	'惠州市实验中学'),
(7,	'惠州市华罗庚中学'),
(8,	'惠州市惠港中学'),
(9,	'惠州市凌田中学'),
(11,	'惠州市田家炳中学'),
(12,	'惠州市小金口中学'),
(13,	'黄冈中学惠州学校'),
(14,	'惠州光正实验学校'),
(15,	'惠州综合高级中学'),
(16,	'惠州一中实验学校'),
(17,	'惠阳区崇雅中学'),
(18,	'惠阳一中实验学校'),
(19,	'惠阳中山中学'),
(20,	'惠阳高级中学'),
(21,	'华师附属惠阳学校'),
(22,	'惠东县高级中学'),
(23,	'惠东县惠东中学'),
(24,	'惠东县平山中学'),
(25,	'惠东县荣超中学'),
(26,	'龙门县高级中学'),
(27,	'龙门县龙门中学'),
(28,	'龙门县永汉中学'),
(29,	'博罗县博罗中学'),
(30,	'博罗县高级中学'),
(31,	'博罗县华侨中学'),
(32,	'博罗县三乡中学'),
(33,	'博罗县石湾中学'),
(34,	'博罗县杨侨中学'),
(35,	'惠州市仲恺中学'),
(36,	'大亚湾第一中学');

DROP TABLE IF EXISTS `goodsstatus`;
CREATE TABLE `goodsstatus` (
  `statusid` int(11) NOT NULL AUTO_INCREMENT,
  `statusdescribe` varchar(20) NOT NULL,
  PRIMARY KEY (`statusid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `goodsstatus` (`statusid`, `statusdescribe`) VALUES
(1,	'进行中'),
(2,	'已完成'),
(3,	'已过期');

DROP TABLE IF EXISTS `goodstype`;
CREATE TABLE `goodstype` (
  `typeid` int(11) NOT NULL AUTO_INCREMENT,
  `goodstype` varchar(10) NOT NULL,
  PRIMARY KEY (`typeid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

INSERT INTO `goodstype` (`typeid`, `goodstype`) VALUES
(1,	'代步工具'),
(2,	'数码产品'),
(3,	'生活百杂'),
(4,	'二手书籍');

DROP TABLE IF EXISTS `goodsuser`;
CREATE TABLE `goodsuser` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `user` varchar(100) NOT NULL,
  `nname` varchar(100) NOT NULL,
  `zname` varchar(100) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `school` varchar(100) NOT NULL,
  `userstatus` varchar(100) DEFAULT '0' COMMENT '是否被封号',
  PRIMARY KEY (`user`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;