CREATE TABLE `bars` (
  `bar_id` varchar(45) NOT NULL DEFAULT '' COMMENT '吧 id',
  `bar_name` varchar(20) NOT NULL DEFAULT '' COMMENT '吧名',
  `enable` int(1) NOT NULL DEFAULT '1' COMMENT '能否使用',
  `post_num` int(10) NOT NULL DEFAULT '0' COMMENT '贴子数',
  `bar_admin_user_id` varchar(45) DEFAULT NULL COMMENT '管理员id',
  `bar_post_table_id` varchar(45) NOT NULL DEFAULT '' COMMENT '吧表对应的贴子表id(表名）',
  `bar_reply_table_id` varchar(45) NOT NULL DEFAULT '' COMMENT '吧表对应的回复表',
  `bar_inner_reply_table_id` varchar(45) NOT NULL DEFAULT '' COMMENT '吧表对应的楼中楼回复表',
  PRIMARY KEY (`bar_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;