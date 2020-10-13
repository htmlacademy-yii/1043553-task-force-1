<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m201012_103753_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'last_active' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),

            'name' => $this->string()->notNull()->unique(),
            'avatar' => $this->string()->defaultValue(\frontend\models\User::DEFAULT_USER_PHOTO),
            'description' => $this->text(),
            'city_id' => $this->integer()->notNull(),
            'birthday' => $this->dateTime()->defaultValue(null),
            'current_role' => $this->tinyInteger()->defaultValue(\frontend\models\User::ROLE_CUSTOMER_CODE),

            'address' => $this->string(255)->defaultValue(null),
            'address_lat' => $this->string(50)->defaultValue(null),
            'address_lon' => $this->string(50)->defaultValue(null),

            'email' => $this->string()->notNull()->unique(),
            'phone' => $this->string(128)->defaultValue(null),
            'skype' => $this->string(128)->defaultValue(null),
            'another_app' => $this->string(128)->defaultValue(null),

            'hide_contacts' => $this->boolean()->defaultValue(0),
            'msg_notification' => $this->boolean()->defaultValue(0),
            'task_action_notification' => $this->boolean()->defaultValue(0),
            'review_notification' => $this->boolean()->defaultValue(0),
            'hide_profile' => $this->boolean()->defaultValue(0),

            'password_hash' => $this->string()->notNull(),
            //'password_reset_token' => $this->string()->unique(),
        ]);

        $this->createIndex(
            '{{%idx-users-city_id}}',
            '{{%users}}',
            'city_id'
        );

        $this->addForeignKey(
            '{{%fk-users-city_id}}',
            '{{%users}}',
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
        $this->dropTable('{{%users}}');
    }
}
