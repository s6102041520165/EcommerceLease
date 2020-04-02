<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lease_detail}}`.
 */
class m200317_042049_create_lease_detail_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%lease_detail}}', [
            'id' => $this->primaryKey(),
            'lease_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'qty' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-lease_detail-lease_id',
            'lease_detail',
            'lease_id',
            'lease',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-lease_detail-product_id',
            'lease_detail',
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
        $this->dropTable('{{%lease_detail}}');
    }
}
