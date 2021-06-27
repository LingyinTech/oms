CREATE DATABASE `db_oms` DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_general_ci;

GRANT ALL PRIVILEGES ON `db_oms`.* TO 'lingyin-oms-app'@'%' IDENTIFIED BY 'Lingyin2021';

CREATE TABLE IF NOT EXISTS `db_oms`.`db_config` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `partner_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  `environment` varchar(8) NOT NULL DEFAULT '' COMMENT '环境',
  `config_name` varchar(32) NOT NULL DEFAULT '' COMMENT '连接名字|尽量重用',
  `class` varchar(32) NOT NULL DEFAULT '' COMMENT '连接处理类',
  `dsn` varchar(128) NOT NULL DEFAULT '' COMMENT 'dsn',
  `login` varchar(16) NOT NULL DEFAULT '' COMMENT '登录账号',
  `password` varchar(32) NOT NULL DEFAULT '0' COMMENT '密码',
  `extra_config`  text NOT NULL COMMENT '补充配置|如从库配置',
  `status`  smallint(3) NOT NULL DEFAULT 0 COMMENT '状态|0数据库未初始化，1删除，10有效',
  `created_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_partner_env` (`partner_id`,`environment`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;