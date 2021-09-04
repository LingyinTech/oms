<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%view_config}}`.
 */
class m210131_080802_create_view_config_table extends Migration
{
    public $testStatus = false;

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $sql = "CREATE TABLE {{%view_config}} (
  `id` bigint(20) unsigned NOT NULL COMMENT '主键ID',
  `partner_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  `sys_view_id`  bigint(20) NOT NULL DEFAULT 0 COMMENT '系统视图',
  `user_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `menu_id` bigint(20) NOT NULL DEFAULT '0' COMMENT '父菜单ID',
  `name` varchar(64) NOT NULL DEFAULT '' COMMENT '视图名称',
  `field_text` text NOT NULL COMMENT '查询字段',
  `condition_text` text NOT NULL COMMENT '查询条件',
  `status` mediumint(3) NOT NULL DEFAULT '2' COMMENT '状态|0未启用，1删除，2私有的，10公开',
  `pre_path` varchar (255) NOT NULL DEFAULT '' COMMENT '路径前辍',
  `is_menu`  tinyint(1) NOT NULL DEFAULT 0 COMMENT '填加菜单|0否，1是',
  `remark` varchar(512) NOT NULL DEFAULT '' COMMENT '备注',
  `created_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `idx_partner_user` (`partner_id`,`user_id`),
  KEY `idx_path` (`path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%view_config}}');
    }
}
