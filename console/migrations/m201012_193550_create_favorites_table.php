<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%favorites}}`.
 */
class m201012_193550_create_favorites_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%favorites}}', [
            'user_id' => $this->integer()->notNull(),
            'fav_user_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('favorites_pk', 'favorites', ['user_id', 'fav_user_id']);

        $this->createIndex(
            '{{%idx-favorites-user_id}}',
            '{{%favorites}}',
            'user_id'
        );

        $this->createIndex(
            '{{%idx-favorites-fav_user_id}}',
            '{{%favorites}}',
            'fav_user_id'
        );

        $this->addForeignKey(
            '{{%fk-favorites-user_id}}',
            '{{%favorites}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-favorites-fav_user_id}}',
            '{{%favorites}}',
            'fav_user_id',
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
        $this->dropTable('{{%favorites}}');
    }
}
