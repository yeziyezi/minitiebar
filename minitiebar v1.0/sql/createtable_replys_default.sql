CREATE TABLE `replys_default` (
  `reply_id` varchar(45) NOT NULL DEFAULT '' COMMENT 'id',
  `user_id` varchar(45) NOT NULL DEFAULT '' COMMENT '回复者id',
  `reply_content` varchar(500) NOT NULL DEFAULT '' COMMENT '回复内容',
  `reply_time` datetime NOT NULL COMMENT '回复时间',
  `post_id` varchar(45) NOT NULL DEFAULT '' COMMENT '回复所在的贴子id',
  PRIMARY KEY (`reply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;