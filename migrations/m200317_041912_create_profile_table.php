<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%profile}}`.
 */
class m200317_041912_create_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey(),
            'f_name' => $this->string(50)->notNull(),
            'l_name' => $this->string(50)->notNull(),
            'picture' => $this->string(50),
            'dob' => $this->date()->notNull(),
            'address' => $this->text(),
            'subdistrict' => $this->string(255)->notNull(),
            'district' => $this->string(255)->notNull(),
            'province' => $this->string(255)->notNull(),
            'zipcode' => $this->string(6)->notNull(),
            'telephone' => $this->string(11)->notNull(),
            'user_id' => $this->integer()->unique()->notNull(),
        ]);

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-profile-user_id',
            'profile',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%profile}}');
    }
}
