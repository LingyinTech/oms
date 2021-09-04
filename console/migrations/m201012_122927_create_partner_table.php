<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%partner}}`.
 */
class m201012_122927_create_partner_table extends Migration
{
    public $dbAllowList = ['db'];

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $sql = "CREATE TABLE IF NOT EXISTS {{%partner}} (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(16) NOT NULL DEFAULT '' COMMENT '标识',
  `short_code` varchar(8) NOT NULL DEFAULT '' COMMENT '简码',
  `name` varchar(128) NOT NULL DEFAULT '' COMMENT '名称',
  `status` smallint(3) NOT NULL DEFAULT '0' COMMENT '状态:0未启用，1删除，2临时有效，10长期有效',
  `active_start` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '有效期开始时间',
  `active_end` bigint(10) unsigned NOT NULL DEFAULT '0' COMMENT '有期效截止时间',
  `created_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '创建时间',
  `updated_at` bigint(10) UNSIGNED NOT NULL DEFAULT '0' COMMENT '更新时间',  
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_code` (`code`) USING BTREE,
  UNIQUE KEY `uniq_short` (`short_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10001 DEFAULT CHARSET=utf8mb4;";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%partner}}');
    }
}
