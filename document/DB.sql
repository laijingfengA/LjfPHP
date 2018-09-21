DROP DATABASE IF EXISTS laijingfeng_dev;

CREATE DATABASE laijingfeng_dev;

USE laijingfeng_dev;

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user`(
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
  username VARCHAR(50) NOT NULL DEFAULT '' COMMENT '帐号',
  password_hash VARCHAR(255) NOT NULL DEFAULT '',
  nickname VARCHAR(255) NOT NULL DEFAULT '' COMMENT '昵称',
--   avatar VARCHAR(255) NOT NULL DEFAULT '' COMMENT '头像',
  email VARCHAR(255) NOT NULL DEFAULT '' COMMENT '邮箱',
  mobile VARCHAR(50) NOT NULL DEFAULT '' COMMENT '手机',
  remember_token VARCHAR(255) DEFAULT '' NOT NULL COMMENT '记住',
  status INT NOT NULL DEFAULT 10 COMMENT '状态', /* 10正常 20禁用 90删除*/

  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '新增时间',
  updated_at DATETIME COMMENT '修改时间',
  KEY username (username(20)),
  KEY email (email(20)),
  KEY mobile (mobile),
  KEY remember_token (remember_token(20))
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1001 COMMENT '用户';

/* 视频 */
DROP TABLE IF EXISTS `video`;
CREATE TABLE IF NOT EXISTS `video`(
	`id` INT AUTO_INCREMENT PRIMARY KEY,
	`user_id` INT NOT NULL DEFAULT 0 COMMENT '用户ID',
	`video_name` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '视频名称',
	`video_link` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '视频链接',
	`width` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '宽度',
	`height` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '高度',
	`status` TINYINT UNSIGNED NOT NULL DEFAULT 10 COMMENT '状态',	/* 10.显示  20.不显示 90.删除 */

	`created_at` DATETIME COMMENT '新增时间',
	`updated_at` DATETIME COMMENT '修改时间'
)ENGINE=InnoDB DEFAULT CHARSET=UTF8 AUTO_INCREMENT=1001 COMMENT='视频';