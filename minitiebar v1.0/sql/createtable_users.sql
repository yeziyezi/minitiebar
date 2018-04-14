CREATE TABLE `users` (
  `user_id` varchar(45) NOT NULL DEFAULT '',
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(20) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `access` int(1) NOT NULL DEFAULT '1' COMMENT '0无权限发帖，1正常发帖',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;