<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%field_config}}`.
 */
class m210119_130346_create_field_config_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE {{%field_config}} (
  `id` bigint(20) NOT NULL COMMENT '主键ID',
  `partner_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '合作伙伴ID|0为系统字段',
  `field` varchar(32) NOT NULL DEFAULT '' COMMENT '数据库字段名',
  `label` varchar(64) NOT NULL DEFAULT '' COMMENT '显示名称',
  `type` varchar(32) NOT NULL DEFAULT '' COMMENT '字段类型',
  `options` longtext NOT NULL COMMENT '候选值|选择类型以竖线分割，时间类型1表示带时分',
  `status` smallint(3) NOT NULL DEFAULT '10' COMMENT '状态|0未启用，1禁用，10 启用',
  `is_system`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '系统字段',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `created_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '添加时间',
  `updated_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%field_config}}');
    }
}
