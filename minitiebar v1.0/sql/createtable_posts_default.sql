CREATE TABLE `posts_default` (
  `post_id` varchar(45) NOT NULL DEFAULT '' COMMENT '贴子id',
  `publish_time` datetime NOT NULL COMMENT '发布时间',
  `last_reply_time` datetime NOT NULL COMMENT '最后回复时间',
  `reply_num` int(10) NOT NULL DEFAULT '0' COMMENT '回复数量（只计算楼层数不算楼中楼）',
  `reply_enable` int(1) NOT NULL DEFAULT '1' COMMENT '是否可被回复，1可0不可',
  `post_title` varchar(45) NOT NULL DEFAULT '无主题的贴子' COMMENT '贴子主题',
  `post_content` varchar(500) NOT NULL DEFAULT '无内容的贴子' COMMENT '贴子内容 500字',
  `user_id` varchar(45) NOT NULL DEFAULT '' COMMENT '发贴人',
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;