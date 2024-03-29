<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%user_info}}`.
 */
class m201009_121148_create_user_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS {{%user_info}} (
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT '用户ID',
  `partner_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  `username` varchar(32) NOT NULL DEFAULT '' COMMENT '姓名',
  `avatar` varchar(128) NOT NULL DEFAULT '' COMMENT '头像',
  `tel` varchar(16) NOT NULL DEFAULT '' COMMENT '办公电话',
  `phone` varchar(16) NOT NULL DEFAULT '' COMMENT '手机号',
  `department_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '部门ID',
  `created_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`user_id`,`partner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%user_info}}');
    }
}
