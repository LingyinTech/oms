<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%db_config}}`.
 */
class m201009_124742_create_db_config_table extends Migration
{

    public $dbAllowList = ['db'];

    public function safeUp()
    {
        $sql = "CREATE TABLE {{%db_config}} (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',  
  `partner_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  `environment` varchar(8) NOT NULL DEFAULT '' COMMENT '环境',
  `config_name` varchar(32) NOT NULL DEFAULT '' COMMENT '连接名字|尽量重用',  
  `class` varchar(32) NOT NULL DEFAULT '' COMMENT '连接处理类',
  `dsn` varchar(128) NOT NULL DEFAULT '' COMMENT 'dsn',
  `login` varchar(16) NOT NULL DEFAULT '' COMMENT '登录账号',
  `password` varchar(32) NOT NULL DEFAULT '0' COMMENT '密码',
  `created_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_partner_env` (`partner_id`,`environment`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%db_config}}');
    }
}
