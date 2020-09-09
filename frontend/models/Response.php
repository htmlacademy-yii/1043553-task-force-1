<?php

namespace frontend\models;

/**
 * This is the model class for table "responses".
 *
 * @property int $id
 * @property int $status
 * @property int $created_at
 * @property int|null $your_price
 * @property int $task_id
 * @property int $user_employee_id
 *
 * @property Tasks $task
 * @property User $userEmployee
 */
class Response extends \yii\db\ActiveRecord
{
    public const STATUS_APPROVED_CODE = 1;
    public const STATUS_REFUSED_CODE = 2;
    public const STATUS_PENDING_CODE = 0;

    public const STATUS_REFUSED_NAME = 'Предложение отклонено';
    public const STATUS_APPROVED_NAME = 'Предложение принято';
    public const STATUS_PENDING_NAME = 'Ожидает подтверждения заказчика';
    public const STATUS_EXCEPTION = 'ошибка определения статуса задания';

    public const GET_POSSIBLE_STATUSES_EXCEPTION = 'Неизвестный индекc в функции getPossibleResponseStatuses';
    public const GET_POSSIBLE_ACTIONS_EXCEPTION = 'Неизвестный индекc в функции getPossibleActions';
    public const PREDICT_STATUS_EXCEPTION = 'Неизвестный индекc в функции predictResponseStatus';
    public const SET_CURRENT_STATUS_EXCEPTION = 'Невозможно поменять статус. Ошибка: ';

    public $userEmployee;
    public $actionButtonsAreVisible;

    public static function authUserHaveNotRespondedToTask(int $taskId): bool
    {
        $response = Response::find()
            ->where(['task_id' => $taskId])
            ->andWhere(['user_employee_id' => \Yii::$app->user->id])
            ->one();

        return !$response;
    }

    public static function authorisedUserIsResponseCreator(Response $response): bool
    {
        return User::idEqualAuthUserId($response->user_employee_id);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'responses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at', 'task_id', 'user_employee_id'], 'required'],
            [['created_at', 'your_price', 'task_id', 'user_employee_id'], 'integer'],
            [
                ['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::className(),
                'targetAttribute' => ['task_id' => 'id']
            ],
            [
                ['user_employee_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_employee_id' => 'id']
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
            'created_at' => 'Created At',
            'your_price' => 'Your Price',
            'task_id' => 'Task ID',
            'user_employee_id' => 'User Employee ID',
        ];
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Tasks::className(), ['id' => 'task_id']);
    }

    /**
     * Gets query for [[UserEmployee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserEmployee()
    {
        return $this->hasOne(User::className(), ['id' => 'user_employee_id']);
    }
}
