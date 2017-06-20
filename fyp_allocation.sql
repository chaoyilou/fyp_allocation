-- create tables under CI

--  后台登陆账号管理
CREATE TABLE `fyp_operator` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(20) NOT NULL,
  `nickname` varchar(40) NULL DEFAULT NULL COMMENT 'operator nickname',
  `password` varchar(50) NOT NULL,
  `supervisor_id` int(11) NULL DEFAULT '0',
  `role_id` int(11) NULL DEFAULT NULL,
  `token` varchar(255) NULL DEFAULT NULL COMMENT 'get some special rights based on token, might be used later',
  `status` char(2) NULL DEFAULT '1' COMMENT '0-Invalid 1-Valid',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `account` (`account`),
  KEY `token` (`token`)
) ENGINE=InnoDB;

--  后台账号菜单管理
CREATE TABLE `fyp_rights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NULL DEFAULT '0',
  `idx` int(5) NULL DEFAULT '0' COMMENT 'sort order',
  `name` varchar(40) NOT NULL COMMENT 'right name',
  `right_key` varchar(100) NOT NULL,
  `uri` varchar(100) NULL DEFAULT NULL COMMENT 'link path',
  `icon` varchar(100) NOT NULL,
  `memo` varchar(100) NULL DEFAULT NULL,
  `status` char(2) NULL DEFAULT '1' COMMENT '0-Invalid 1-Valid',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  `is_menu` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `right_key` (`right_key`)
) ENGINE=InnoDB;

--  后台账号权限管理
CREATE TABLE `fyp_role_rights` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  `right_key` varchar(100) NOT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB COMMENT='connect role_id to right_id';

-- 后台账号角色管理
CREATE TABLE `fyp_roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL COMMENT 'role name',
  `status` char(2) NULL DEFAULT '1' COMMENT '0-Invalid 1-Valid',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- 学生账号管理
CREATE TABLE `fyp_students` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(40) NOT NULL COMMENT 'student name',
  `headimgurl` varchar(1024) NOT NULL COMMENT 'link to student picture',
  `desc` text NOT NULL COMMENT 'student description',
  `email` varchar(60) NOT NULL,
  `stream` varchar(40) NOT NULL COMMENT '1-EEE Beng 2-EIE Beng 3-EEE Meng 4-EIE Meng',
  `project_wishes` text NOT NULL COMMENT 'wish list, saved in JSON',
  `read_mark` text NOT NULL COMMENT 'projects that have been read, saved in JSON',
  `status` char(2) NULL DEFAULT '1' COMMENT '0-Invalid 1-Valid',
  `memo` varchar(1024) NULL DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

--  教授管理
CREATE TABLE `fyp_supervisors` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL COMMENT 'supervisor name',
  `headimgurl` varchar(1024) NOT NULL COMMENT 'link to supervisor picture',
  `email` varchar(60) NOT NULL,
  `room` varchar(60) NOT NULL,
  `homepage` varchar(255) NOT NULL,
  `appointment_preference` char(2) NOT NULL COMMENT '1-individual meeting 2-group meeting 3-both',
  `status` char(2) NULL DEFAULT '1' COMMENT '0-Invalid 1-Valid',
  `memo` varchar(1024) NULL DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

--  课题管理
CREATE TABLE `fyp_projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `supervisor_id` int(11) NOT NULL COMMENT 'connect to supervisor id',
  `PID` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `stream` char(100) NOT NULL COMMENT '1-EEE Beng 2-EIE Beng 3-EEE Meng 4-EIE Meng',
  `desc` text NOT NULL COMMENT 'length unknown，using text, text has 2^16-1 bytes',
  `required_ability` varchar(255) NULL DEFAULT NULL,
  `difficulty_min` varchar(10) NULL DEFAULT '0' COMMENT 'eg. 50',
  `difficulty_max` varchar(10) NULL DEFAULT '0' COMMENT 'eg. 70',
  `status` char(2) NULL DEFAULT '1' COMMENT '0-Invalid 1-Valid',
  `memo` varchar(1024) NULL DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project_no` (`project_no`)
) ENGINE=InnoDB;

-- 学生课题选择管理
CREATE TABLE `fyp_student_projects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `project_rank` int(11) NOT NULL COMMENT 'rank defined by student',
  `status` char(2) NULL DEFAULT '1' COMMENT '0-Invalid 1-Valid',
  `comment` text NULL DEFAULT NULL,
  `memo` varchar(1024) NULL DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

--  学生会议预约管理
CREATE TABLE `fyp_student_meetings` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `supervisor_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `appointment_time` timestamp NULL DEFAULT NULL COMMENT '预约时间',
  `meeting_room` varchar(60) NOT NULL COMMENT '会议地点',
  `appointment_preference` char(100) NOT NULL,
  `meeting_content` text NULL DEFAULT NULL COMMENT '会议内容记录',
  `status` char(2) NULL DEFAULT '0' COMMENT '0-预约提交 1-预约通过（但未完成） 2-预约拒绝 3-预约完成 4-其他',
  `memo` varchar(1024) NULL DEFAULT NULL,
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

--  系统设置管理
CREATE TABLE `fyp_system_setting` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `start_time` timestamp NULL DEFAULT NULL COMMENT '选课开始时间',
  `end_time` timestamp NULL DEFAULT NULL COMMENT '选课结束时间',
  `create_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;