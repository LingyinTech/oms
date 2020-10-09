
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '角色名',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `partner_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  PRIMARY KEY (`id`),
  KEY `ename` (`sort`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `node`;
CREATE TABLE `node` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `label` varchar(64) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '路径',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `status` smallint(3) NOT NULL DEFAULT '10' COMMENT '状态，0未开放，1删除，2动作，10菜单',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Table structure for table `partner`
--

DROP TABLE IF EXISTS `partner`;
CREATE TABLE `partner` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(16) NOT NULL DEFAULT '' COMMENT '标识',
  `short_code` varchar(6) NOT NULL DEFAULT '' COMMENT '简码',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '名称',
  `status` smallint(3) NOT NULL DEFAULT '0' COMMENT '状态:0未启用，1删除，2临时有效，10长期有效',
  `active_start` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '有效期开始时间',
  `active_end` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '有期效截止时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_code` (`code`) USING BTREE,
  UNIQUE KEY `uniq_short` (`short_code`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `created_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `status` tinyint(3) NOT NULL DEFAULT '10' COMMENT '0未开放，1删除，10开放',
  `partner_id` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  PRIMARY KEY (`id`),
  KEY `ename` (`sort`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `role_node`;
CREATE TABLE `role_node` (
  `role_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `node_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '节点ID',
  PRIMARY KEY (`role_id`,`node_id`),
  KEY `index_node` (`node_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `role_user`;
CREATE TABLE `role_user` (
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `role_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `idx_role` (`role_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '用户名',
  `auth_key` varchar(32) NOT NULL DEFAULT '' COMMENT 'auth_key',
  `password_hash` varchar(255) NOT NULL DEFAULT '' COMMENT '密码hash',
  `password_reset_token` varchar(255) NOT NULL DEFAULT '' COMMENT 'password_reset_token',
  `status` smallint(6) NOT NULL DEFAULT '0' COMMENT '状态，0未激活，1删除，10激活',
  `created_at` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` int(11) NOT NULL DEFAULT '0' COMMENT '更新时间',
  `partner_id` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`username`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `user_info`;
CREATE TABLE `user_info` (
  `user_id` bigint(10) unsigned NOT NULL COMMENT '用户ID',
  `real_name` varchar(16) NOT NULL DEFAULT '' COMMENT '姓名',
  `email` varchar(128) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `avatar` varchar(128) NOT NULL DEFAULT '' COMMENT '头像',
  `tel` varchar(16) NOT NULL DEFAULT '' COMMENT '办公电话',
  `phone` varchar(16) NOT NULL DEFAULT '' COMMENT '手机号',
  `department_id` bigint(10) NOT NULL DEFAULT '0' COMMENT '部门ID',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uniq_email` (`email`) USING BTREE,
  UNIQUE KEY `uniq_user` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `user_login_log`;
CREATE TABLE `user_login_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `lang` char(2) NOT NULL DEFAULT 'en' COMMENT '登录语言',
  `plat` tinyint(3) NOT NULL DEFAULT '1' COMMENT '登录平台',
  `ip` varchar(64) NOT NULL DEFAULT '' COMMENT '登录IP',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '登录时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `user_open`;
CREATE TABLE `user_open` (
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',
  `site_name` varchar(32) NOT NULL DEFAULT '' COMMENT '第三方网站标识',
  `open_id` varchar(64) NOT NULL DEFAULT '' COMMENT '第三方登录ID，如fb_uid',
  `access_token` varchar(255) NOT NULL DEFAULT '' COMMENT 'access_token',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `uniq_user_site` (`user_id`,`site_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

