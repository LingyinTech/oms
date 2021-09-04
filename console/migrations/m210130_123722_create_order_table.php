<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%order}}`.
 */
class m210130_123722_create_order_table extends Migration
{
    public $testStatus = false;

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $sql = "";
        $this->execute($sql);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%order}}');
    }
}
