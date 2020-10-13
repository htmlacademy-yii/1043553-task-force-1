<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_categories}}`.
 */
class m201012_193443_create_users_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_categories}}', [
            'user_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('users_categories_pk', 'users_categories', ['user_id', 'category_id']);

        $this->createIndex(
            '{{%idx-users_categories-user_id}}',
            '{{%users_categories}}',
            'user_id'
        );

        $this->createIndex(
            '{{%idx-users_categories-category_id}}',
            '{{%users_categories}}',
            'category_id'
        );

        $this->addForeignKey(
            '{{%fk-users_categories-user_id}}',
            '{{%users_categories}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-users_categories-category_id}}',
            '{{%users_categories}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users_categories}}');
    }
}
