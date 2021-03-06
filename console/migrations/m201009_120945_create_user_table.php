<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m201009_120945_create_user_table extends Migration
{
    public $dbAllowList = ['db'];

    public $testStatus = true;

    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS {{%user}} (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `email` varchar(128) NOT NULL DEFAULT '' COMMENT '用户邮箱',
  `auth_key` varchar(32) NOT NULL DEFAULT '' COMMENT 'auth_key',
  `password_hash` varchar(255) NOT NULL DEFAULT '' COMMENT '密码hash',
  `password_reset_token` varchar(255) NOT NULL DEFAULT '' COMMENT 'password_reset_token',
  `status` smallint(3) NOT NULL DEFAULT '0' COMMENT '状态，0未激活，1删除，10激活',
  `created_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `current_partner_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_email` (`email`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
