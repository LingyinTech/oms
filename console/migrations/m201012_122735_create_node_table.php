<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%node}}`.
 */
class m201012_122735_create_node_table extends Migration
{
    public $dbAllowList = ['db'];

    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS {{%node}} (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '父级ID',
  `label` varchar(64) NOT NULL DEFAULT '' COMMENT '菜单名称',
  `url` varchar(255) NOT NULL DEFAULT '' COMMENT '路径',
  `icon` varchar(255) NOT NULL DEFAULT '' COMMENT '图标',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `sort` smallint(3) unsigned NOT NULL DEFAULT '99' COMMENT '排序',
  `status` smallint(3) NOT NULL DEFAULT '10' COMMENT '状态，0未开放，1删除，2动作，10菜单',
  `created_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%node}}');
    }
}
