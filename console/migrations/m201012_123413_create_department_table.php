<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%department}}`.
 */
class m201012_123413_create_department_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE IF NOT EXISTS {{%department}} (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '自增ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '角色名',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `created_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `partner_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  PRIMARY KEY (`id`),
  KEY `idx_partner_id` (`partner_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%department}}');
    }
}
