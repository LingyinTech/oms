<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%original_order_child}}`.
 */
class m210130_125831_create_original_order_child_table extends Migration
{
    public $testStatus = false;

    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%original_order_child}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%original_order_child}}');
    }
}
