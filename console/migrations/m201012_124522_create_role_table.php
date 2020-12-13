<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%role}}`.
 */
class m201012_124522_create_role_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE IF NOT EXISTS {{%role}} (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT '自增ID',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '角色名',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `status` smallint(3) NOT NULL DEFAULT '10' COMMENT '0未开放，1删除，10开放',
  `created_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  `partner_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  PRIMARY KEY (`id`),
  KEY `ename` (`sort`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%role}}');
    }
}
