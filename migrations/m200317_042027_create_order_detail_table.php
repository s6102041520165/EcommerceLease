<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%order_detail}}`.
 */
class m200317_042027_create_order_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%order_detail}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
        ]);

        // add foreign key for table `orders`
        $this->addForeignKey(
            'fk-order_detail-order_id',
            'order_detail',
            'order_id',
            'orders',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-order_detail-product_id',
            'order_detail',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_detail}}');
    }
}
