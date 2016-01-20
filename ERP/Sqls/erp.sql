# Host: localhost  (Version: 5.5.40)
# Date: 2016-01-20 21:50:57
# Generator: MySQL-Front 5.3  (Build 4.120)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "config_btn"
#

CREATE TABLE `config_btn` (
  `BtnId` varchar(6) NOT NULL DEFAULT '' COMMENT '按钮Id',
  `BtnClass` varchar(255) NOT NULL DEFAULT '' COMMENT '按钮类名',
  `BtnName` varchar(255) NOT NULL DEFAULT '' COMMENT '按钮名',
  `BtnIcon` varchar(255) NOT NULL DEFAULT '' COMMENT '按钮图标类名',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '是否激活',
  PRIMARY KEY (`BtnId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='按钮';

#
# Data for table "config_btn"
#

INSERT INTO `config_btn` VALUES ('1','EasyLib-Btn-Close','关闭','icon-clear',1),('2','EasyLib-Btn-Reload','刷新','icon-reload',1),('3','EasyLib-Btn-Print','打印','icon-print',1),('4','EasyLib-Btn-Search','查询','icon-search',1),('5','EasyLib-Btn-Add','新增','icon-add',1),('6','EasyLib-Btn-Remove','删除','icon-remove',1),('7','EasyLib-Btn-Edit','编辑','icon-edit',1),('8','EasyLib-Btn-Save','保存','icon-save',1),('9','EasyLib-Btn-Enter','确定','icon-ok',1);

#
# Structure for table "config_custom_menu"
#

CREATE TABLE `config_custom_menu` (
  `MenuId` varchar(6) NOT NULL DEFAULT '' COMMENT '菜单Id',
  `MenuName` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单名',
  `NodeLevel` int(11) NOT NULL DEFAULT '0' COMMENT '树节点层级',
  `ParentMenuId` varchar(6) NOT NULL DEFAULT '' COMMENT '父菜单Id',
  `UserId` varchar(20) NOT NULL DEFAULT '' COMMENT '用户Id',
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '关联的页面Id',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '是否激活',
  `Seq` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`MenuId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='菜单';

#
# Data for table "config_custom_menu"
#


#
# Structure for table "config_group"
#

CREATE TABLE `config_group` (
  `GroupId` varchar(6) NOT NULL DEFAULT '' COMMENT '用户组Id',
  `GroupName` varchar(255) NOT NULL DEFAULT '' COMMENT '用户组名',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '是否激活',
  PRIMARY KEY (`GroupId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='用户组';

#
# Data for table "config_group"
#


#
# Structure for table "config_group_auth"
#

CREATE TABLE `config_group_auth` (
  `GroupId` varchar(6) NOT NULL DEFAULT '' COMMENT '用户组Id',
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '页面Id',
  `OP` varchar(255) NOT NULL DEFAULT '' COMMENT '页面按钮权限 2 进制表示',
  `QueryParams` varchar(1000) NOT NULL DEFAULT '' COMMENT '查询条件字段 ; 隔开',
  `ShowFields` varchar(1000) NOT NULL DEFAULT '' COMMENT '页面显示字段 ; 隔开',
  PRIMARY KEY (`GroupId`,`PageId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='用户组_权限';

#
# Data for table "config_group_auth"
#


#
# Structure for table "config_group_user"
#

CREATE TABLE `config_group_user` (
  `GroupId` varchar(6) NOT NULL DEFAULT '' COMMENT '用户组Id',
  `UserId` varchar(6) NOT NULL DEFAULT '' COMMENT '用户Id',
  PRIMARY KEY (`GroupId`,`UserId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='用户组_用户';

#
# Data for table "config_group_user"
#


#
# Structure for table "config_menu"
#

CREATE TABLE `config_menu` (
  `MenuId` varchar(6) NOT NULL DEFAULT '' COMMENT '菜单Id',
  `MenuName` varchar(255) NOT NULL DEFAULT '' COMMENT '菜单名',
  `NodeLevel` int(11) NOT NULL DEFAULT '0' COMMENT '树节点层级',
  `ParentMenuId` varchar(6) NOT NULL DEFAULT '' COMMENT '父菜单Id',
  `ModuleId` varchar(20) NOT NULL DEFAULT '' COMMENT '所属模块Id',
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '关联的页面Id',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '是否激活',
  `Seq` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`MenuId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='菜单';

#
# Data for table "config_menu"
#

INSERT INTO `config_menu` VALUES ('100000','系统管理',0,'0','System','0',1,0),('100001','功能1',1,'100000','System','0',1,0),('100002','功能2',1,'100000','System','0',1,1),('100003','页面1',2,'100001','System','100000',1,0),('100004','页面1',2,'100001','System','100000',1,1),('100005','页面1',2,'100001','System','100000',1,2),('100006','页面1',2,'100002','System','100000',1,0),('100007','页面1',2,'100002','System','100000',1,1),('100008','页面1',2,'100002','System','100000',1,2),('100009','页面1',2,'100002','System','100000',1,3),('100010','页面1',2,'100002','System','100000',1,4),('100011','功能3',1,'100000','System','0',1,0),('100012','功能33',2,'100011','System','0',1,0),('100013','功能333',3,'100012','System','0',1,0),('100014','功能3333',4,'100013','System','0',1,0),('100015','功能33333',5,'100014','System','0',1,0);

#
# Structure for table "config_module"
#

CREATE TABLE `config_module` (
  `ModuleId` varchar(20) NOT NULL DEFAULT '' COMMENT '模块Id',
  `ModuleName` varchar(255) NOT NULL DEFAULT '' COMMENT '模块名',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '是否激活',
  `Seq` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`ModuleId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='模块';

#
# Data for table "config_module"
#

INSERT INTO `config_module` VALUES ('BaseData','基础数据',1,1),('Sale','销售',1,2),('Stock','库存',1,3),('System','系统配置',1,0);

#
# Structure for table "config_page"
#

CREATE TABLE `config_page` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '页面Id',
  `PageName` varchar(255) NOT NULL DEFAULT '' COMMENT '页面名字',
  `ModuleId` varchar(20) NOT NULL DEFAULT '' COMMENT '所属模块Id',
  `Controller` varchar(255) NOT NULL DEFAULT '' COMMENT '控制器',
  `Action` varchar(255) NOT NULL DEFAULT '' COMMENT '方法',
  `OuterLink` varchar(255) DEFAULT '' COMMENT '外链接',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '是否激活',
  PRIMARY KEY (`PageId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='页面';

#
# Data for table "config_page"
#

INSERT INTO `config_page` VALUES ('100000','测试页面1','System','test','test','',1);

#
# Structure for table "config_page_btn"
#

CREATE TABLE `config_page_btn` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '页面Id',
  `BtnId` varchar(6) NOT NULL DEFAULT '' COMMENT '按钮Id',
  `IsActive` int(11) NOT NULL DEFAULT '1' COMMENT '是否激活',
  `Seq` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`PageId`,`BtnId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='页面按钮';

#
# Data for table "config_page_btn"
#


#
# Structure for table "config_page_param"
#

CREATE TABLE `config_page_param` (
  `PageId` varchar(6) NOT NULL DEFAULT '' COMMENT '页面Id',
  `QueryParams` varchar(1000) NOT NULL DEFAULT '' COMMENT '查询条件字段 ; 隔开',
  `ShowFields` varchar(1000) NOT NULL DEFAULT '' COMMENT '页面显示字段 ; 隔开',
  PRIMARY KEY (`PageId`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk COMMENT='页面_参数';

#
# Data for table "config_page_param"
#

