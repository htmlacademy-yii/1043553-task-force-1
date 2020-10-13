<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%chat_messages}}`.
 */
class m201012_193517_create_chat_messages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%chat_messages}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'task_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text(),
            'viewed' => $this->boolean()->defaultValue(0),
        ]);

        $this->createIndex(
            '{{%idx-chat_messages-task_id}}',
            '{{%chat_messages}}',
            'task_id'
        );

        $this->createIndex(
            '{{%idx-chat_messages-user_id}}',
            '{{%chat_messages}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-chat_messages-task_id}}',
            '{{%chat_messages}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-chat_messages-user_id}}',
            '{{%chat_messages}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%chat_messages}}');
    }
}
