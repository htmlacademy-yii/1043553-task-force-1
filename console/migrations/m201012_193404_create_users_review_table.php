<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users_review}}`.
 */
class m201012_193404_create_users_review_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users_review}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),

            'task_id' => $this->integer(),
            'user_customer_id' => $this->integer(),
            'user_employee_id' => $this->integer(),

            'vote' => $this->integer()->notNull(),
            'review' => $this->text()->defaultValue(null),
        ]);

        $this->createIndex(
            '{{%idx-users_review-task_id}}',
            '{{%users_review}}',
            'task_id'
        );

        $this->createIndex(
            '{{%idx-users_review-user_customer_id}}',
            '{{%users_review}}',
            'user_customer_id'
        );

        $this->createIndex(
            '{{%idx-users_review-user_employee_id}}',
            '{{%users_review}}',
            'user_employee_id'
        );

        $this->addForeignKey(
            '{{%fk-users_review-task_id}}',
            '{{%users_review}}',
            'task_id',
            '{{%tasks}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-users_review-user_customer_id}}',
            '{{%users_review}}',
            'user_customer_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-users_review-user_employee_id}}',
            '{{%users_review}}',
            'user_employee_id',
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
        $this->dropTable('{{%users_review}}');
    }
}
