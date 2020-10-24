<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m201012_185900_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),

            'user_customer_id' => $this->integer()->notNull(),
            'user_employee_id' => $this->integer()->defaultValue(null),

            'category_id' => $this->integer()->notNull(),
            'city_id' => $this->integer()->defaultValue(null),

            'title' => $this->string(128)->notNull(),
            'description' => $this->text()->defaultValue(null),
            'budget' => $this->integer()->defaultValue(null),
            'deadline' => $this->dateTime()->notNull(),
            'current_status' => $this->integer()->defaultValue(\frontend\models\Task::STATUS_NEW_CODE),

            'address' => $this->string(255)->defaultValue(null),
            'lat' => $this->string(50)->defaultValue(null),
            'lon' => $this->string(50)->defaultValue(null),
        ]);

        $this->createIndex(
            '{{%idx-tasks-user_customer_id}}',
            '{{%tasks}}',
            'user_customer_id'
        );

        $this->createIndex(
            '{{%idx-tasks-user_employee_id}}',
            '{{%tasks}}',
            'user_employee_id'
        );

        $this->createIndex(
            '{{%idx-tasks-category_id}}',
            '{{%tasks}}',
            'category_id'
        );

        $this->createIndex(
            '{{%idx-tasks-city_id}}',
            '{{%tasks}}',
            'city_id'
        );

        $this->addForeignKey(
            '{{%fk-tasks-user_customer_id}}',
            '{{%tasks}}',
            'user_customer_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-tasks-user_employee_id}}',
            '{{%tasks}}',
            'user_employee_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-tasks-category_id}}',
            '{{%tasks}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-tasks-city_id}}',
            '{{%tasks}}',
            'city_id',
            '{{%cities}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tasks}}');
    }
}
