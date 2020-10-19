<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%role_node}}`.
 */
class m201009_132202_create_role_node_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = "CREATE TABLE {{%role_node}} (
  `role_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '角色ID',
  `node_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '节点ID',
  `partner_id` bigint(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT '合作伙伴ID',
  PRIMARY KEY (`role_id`,`node_id`, `partner_id`),
  KEY `index_node` (`node_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%role_node}}');
    }
}
