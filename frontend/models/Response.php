<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "responses".
 *
 * @property int $id
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
    public $userEmployee;
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
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Tasks::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['user_employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_employee_id' => 'id']],
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
