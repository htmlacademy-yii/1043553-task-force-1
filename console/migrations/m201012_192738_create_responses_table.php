<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%responses}}`.
 */
class m201012_192738_create_responses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%responses}}', [
            'id' => $this->primaryKey(),

            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'user_employee_id' => $this->integer()->notNull(),
            'task_id' => $this->integer()->notNull(),

            'status' => $this->integer()->defaultValue(\frontend\models\Response::STATUS_PENDING_CODE),
            'comment' => $this->string(128)->defaultValue(null),
            'your_price' => $this->integer()->defaultValue(null),
        ]);

        $this->createIndex(
            '{{%idx-responses-user_employee_id}}',
            '{{%responses}}',
            'user_employee_id'
        );

        $this->createIndex(
            '{{%idx-responses-task_id}}',
            '{{%responses}}',
            'task_id'
        );

        $this->addForeignKey(
            '{{%fk-responses-user_employee_id}}',
            '{{%responses}}',
            'user_employee_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-responses-task_id}}',
            '{{%responses}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%responses}}');
    }
}
