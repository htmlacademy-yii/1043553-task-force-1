<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id Идентификатор
 * @property int $task_id Задание
 * @property int $user_id Пользователь
 * @property int $is_mine Сообщение заказчика
 * @property string $message Текст сообщения
 * @property string $dt_add Время создания записи
 *
 * @property Task $task
 * @property User $contractor
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['task_id', 'user_id', 'is_mine', 'message'], 'required'],
            [['task_id', 'user_id', 'is_mine'], 'integer'],
            [['dt_add'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [
                ['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::className(),
                'targetAttribute' => ['task_id' => 'id']
            ],
            [
                ['contractor_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['contractor_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'task_id' => 'Task ID',
            'user_id' => 'User ID',
            'is_mine' => 'Is Mine',
            'message' => 'Message',
            'created_at' => 'created at',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * Gets query for [[Contractor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'contractor_id']);
    }
}

