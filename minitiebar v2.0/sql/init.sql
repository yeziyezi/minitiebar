CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10',
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  `nickname` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nickname` (`nickname`),
  UNIQUE KEY `password_reset_token` (`password_reset_token`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `bar` (
  `id` varchar(45) NOT NULL DEFAULT '' COMMENT '吧id',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `post_number` int(10) NOT NULL DEFAULT '0' COMMENT '贴子数量',
  `intro` varchar(100) NOT NULL DEFAULT '尚无简介' COMMENT '吧简介',
  `name` varchar(30) NOT NULL DEFAULT '',
  `create_user` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `create_user` (`create_user`),
  CONSTRAINT `bar_ibfk_1` FOREIGN KEY (`create_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `post` (
  `id` varchar(45) NOT NULL DEFAULT '' COMMENT '贴子id',
  `title` varchar(30) NOT NULL DEFAULT '' COMMENT '主题',
  `content` varchar(500) NOT NULL DEFAULT '' COMMENT '内容',
  `publish_time` datetime NOT NULL COMMENT '发布时间',
  `last_reply_time` datetime NOT NULL COMMENT '最后回复时间',
  `reply_number` int(11) NOT NULL COMMENT '回复数',
  `publish_user` int(11) NOT NULL COMMENT '发布者',
  `reply_status` int(1) NOT NULL DEFAULT '0' COMMENT '状态0正常1禁止回复',
  `stick_status` int(1) NOT NULL DEFAULT '0' COMMENT '状态0非置顶1置顶',
  `bar_id` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `publish_user` (`publish_user`),
  KEY `bar_id` (`bar_id`),
  CONSTRAINT `post_ibfk_1` FOREIGN KEY (`publish_user`) REFERENCES `user` (`id`),
  CONSTRAINT `post_ibfk_2` FOREIGN KEY (`bar_id`) REFERENCES `bar` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `reply` (
  `id` varchar(45) NOT NULL DEFAULT '',
  `publish_user` int(11) NOT NULL,
  `publish_time` datetime NOT NULL,
  `content` varchar(500) NOT NULL DEFAULT '',
  `post_id` varchar(45) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `publish_user` (`publish_user`),
  KEY `post_id` (`post_id`),
  CONSTRAINT `reply_ibfk_1` FOREIGN KEY (`publish_user`) REFERENCES `user` (`id`),
  CONSTRAINT `reply_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `inner_reply` (
  `id` varchar(45) NOT NULL DEFAULT '',
  `publish_user` int(11) NOT NULL,
  `publish_time` datetime NOT NULL,
  `content` varchar(500) NOT NULL DEFAULT '',
  `reply_id` varchar(45) NOT NULL DEFAULT '',
  `to_user` int(11) NOT NULL,
  `type` int(1) NOT NULL COMMENT '0回复当前楼层1回复楼中楼',
  PRIMARY KEY (`id`),
  KEY `publish_user` (`publish_user`),
  KEY `reply_id` (`reply_id`),
  KEY `to_user` (`to_user`),
  CONSTRAINT `inner_reply_ibfk_1` FOREIGN KEY (`publish_user`) REFERENCES `user` (`id`),
  CONSTRAINT `inner_reply_ibfk_2` FOREIGN KEY (`reply_id`) REFERENCES `reply` (`id`),
  CONSTRAINT `inner_reply_ibfk_3` FOREIGN KEY (`to_user`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;