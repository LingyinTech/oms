<?php

use console\base\Migration;

/**
 * Handles the creation of table `{{%original_order}}`.
 */
class m210130_125819_create_original_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%original_order}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%original_order}}');
    }
}
