<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%payment}}`.
 */
class m200317_042100_create_payment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payment}}', [
            'id' => $this->primaryKey(),
            'receipt_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'location' => $this->string(255),
            'source_bank' => $this->string(255)->notNull(),
            'destination_bank' => $this->integer()->notNull(),
            'slip' => $this->string()->notNull(),
            'created_by' => $this->integer(),
            'updated_by' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-payment-destination_bank',
            'payment',
            'destination_bank',
            'bank',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%payment}}');
    }
}
