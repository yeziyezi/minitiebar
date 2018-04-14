CREATE TABLE `inner_replys_default` (
  `inner_reply_id` varchar(45) NOT NULL DEFAULT '' COMMENT '楼中楼主键',
  `to_user_id` varchar(45) NOT NULL DEFAULT '' COMMENT '被回复者',
  `from_user_id` varchar(45) NOT NULL DEFAULT '' COMMENT '回复者',
  `ir_content` varchar(500) NOT NULL DEFAULT '' COMMENT '回复内容',
  `reply_id` varchar(45) NOT NULL DEFAULT '' COMMENT '所属楼层的id',
  `reply_time` datetime NOT NULL COMMENT '回复时间',
  `reply_to_id` varchar(45) NOT NULL DEFAULT '' COMMENT '这条楼中楼是对谁回复的：前缀ir回复楼中楼，前缀r回复层主',
  PRIMARY KEY (`inner_reply_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;