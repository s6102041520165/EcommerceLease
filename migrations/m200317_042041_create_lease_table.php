<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%lease}}`.
 */
class m200317_042041_create_lease_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%lease}}', [
            'id' => $this->primaryKey(),
            'lease_date' => $this->date()->notNull(),
            'lease_time' => $this->time()->notNull(),
            'due_date' => $this->date()->notNull(),
            'due_time' => $this->time()->notNull(),
            'description' => $this->text(),
            'grand_total' => $this->double()->notNull(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
            'updated_at' => $this->integer(),
            'updated_by' => $this->integer(),
            'status' => $this->integer()->defaultValue(8),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%lease}}');
    }
}
