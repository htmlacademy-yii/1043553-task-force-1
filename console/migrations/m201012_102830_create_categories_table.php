<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks_categories}}`.
 */
class m201012_102830_create_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%categories}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            'image' => $this->string(128)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tasks_categories}}');
    }
}
