<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks_files}}`.
 */
class m201012_192347_create_tasks_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%tasks_files}}', [
            'id' => $this->primaryKey(),
            'file' => $this->string(128)->notNull(),
            'task_id' => $this->integer(),
        ]);

        $this->createIndex(
            '{{%idx-tasks_files-task_id}}',
            '{{%tasks_files}}',
            'task_id'
        );

        $this->addForeignKey(
            '{{%fk-tasks_files-task_id}}',
            '{{%tasks_files}}',
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
        $this->dropTable('{{%tasks_files}}');
    }
}
