/**
 * bluebridge sql
 * @author: gongcy
 * @date: 16-10-31 下午8:17
 */

CREATE TABLE solution_blue (
  `submit_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '蓝桥模式提交自增id',
  `user_id` varchar(48) NOT NULL DEFAULT '' COMMENT '比赛代码',
  `contest_code` varchar(40) NOT NULL DEFAULT '' COMMENT '比赛代码',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '问题id',
  `ans` text DEFAULT '' COMMENT '提交答案',
  `solution_id` int(11) DEFAULT NULL DEFAULT '0' COMMENT 'ACM模式提交id',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '分数',
  `is_correct` int(1) DEFAULT '0' DEFAULT '0' COMMENT '答案正确标志',
  `submit_time` datetime NOT NULL DEFAULT '0000-00-00' COMMENT '提交时间',
  `type` int(1) NOT NULL DEFAULT '0' COMMENT '提交题目类型',
  `ip` varchar(20) NOT NULL DEFAULT '' COMMENT '提交ip',
  PRIMARY KEY (`submit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT ='蓝桥模式提交记录表';

CREATE TABLE `contest_blue` (
  `contest_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '比赛自增id',
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '比赛名称',
  `start_time` datetime NOT NULL DEFAULT '0000-00-00' COMMENT '比赛开始时间',
  `end_time` datetime NOT NULL DEFAULT '0000-00-00' COMMENT '比赛结束时间',
  `defunct` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N' COMMENT '废弃标志',
  `description` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '比赛描述',
  `lang` int(1) NOT NULL DEFAULT '0' COMMENT '比赛语言',
  `password` char(16) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '比赛密码',
  PRIMARY KEY (`contest_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT ='蓝桥模式比赛表';

CREATE TABLE `contest_blue_problem` (
  `problem_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '比赛题目自增id',
  `contest_id` int(11) NOT NULL DEFAULT '0' COMMENT '比赛id',
  `title` char(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '',
  `type` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '题目类型',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '题目分值',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '题目序号',
  PRIMARY KEY (`problem_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT ='蓝桥模式比赛题目表';

CREATE TABLE `problem_fillblank` (
  `problem_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '填空题自增id',
  `title` varchar(200) COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '题目名称',
  `description` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '题目描述',
  `solution` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '题目正确答案',
  `hint` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '' COMMENT '题目提示',
  `defunct` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'N' COMMENT '废弃标志',
  PRIMARY KEY (`problem_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT ='蓝桥模式填空题表';
