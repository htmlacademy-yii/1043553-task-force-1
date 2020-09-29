<?php

namespace frontend\models;

use frontend\components\helpers\TimeOperations;
use frontend\components\task\TaskAccessComponent;
use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id Идентификатор
 * @property int $task_id Задание
 * @property int $user_id Пользователь
 * @property int $is_mine Сообщение заказчика
 * @property string $message Текст сообщения
 * @property string $created_at Время создания записи
 *
 * @property Task $task
 * @property User $user
 */
class ChatMessage extends \yii\db\ActiveRecord
{
    public $is_mine;

    public function saveMessage(string $message, int $taskId): bool
    {
        if (TaskAccessComponent::taskIsNotAccessible($taskId)) {
            return false;
        }
        $this->task_id = $taskId;
        $this->user_id = Yii::$app->user->getId();
        $this->message = $message;
        $this->created_at = time();
        return $this->save(false);
    }

    public static function getChatMessagesForSelectedTask(int $taskId)
    {
        $messages = self::find()->where(['task_id' => $taskId])->all();

        $messagesClone = [];

        foreach ($messages as $key => $message) {
            $messagesClone[$key] = $message;
            $messagesClone[$key]['is_mine'] = User::idEqualAuthUserId($message['user_id']);
            $messagesClone[$key]['created_at'] = TimeOperations::timePassed($message['created_at']);
        }

        return $messagesClone;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[['task_id', 'user_id', 'is_mine', 'message'], 'required'],
            //[['message'], 'required'],
            [['task_id', 'user_id', 'is_mine'], 'integer'],
            [['created_at'], 'safe'],
            [['message'], 'string', 'max' => 255],
            [
                ['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::className(),
                'targetAttribute' => ['task_id' => 'id']
            ],
            [
                ['user_id'],
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
            //'is_mine' => 'Is Mine',
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
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}

