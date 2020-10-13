<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_photos}}`.
 */
class m201012_192939_create_user_photos_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_photos}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'photo' => $this->string(128)->notNull(),
        ]);

        $this->createIndex(
            '{{%idx-user_photos-user_id}}',
            '{{%user_photos}}',
            'user_id'
        );

        $this->addForeignKey(
            '{{%fk-user_photos-user_id}}',
            '{{%user_photos}}',
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
        $this->dropTable('{{%user_photos}}');
    }
}
