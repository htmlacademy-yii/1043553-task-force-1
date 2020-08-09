<?php

namespace frontend\models;

/**
 * This is the model class for table "users_review".
 *
 * @property int $id
 * @property int $created_at
 * @property int $user_customer_id
 * @property int $user_employee_id
 * @property int $vote
 * @property string $review
 *
 * @property Users $userCustomer
 * @property Users $userEmployee
 */
class UserReview extends \yii\db\ActiveRecord
{
    public $customerPhoto;
    public $customerName;
    public $taskTitle;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
         return 'users_review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
         return [
            [['created_at', 'user_customer_id', 'user_employee_id', 'vote', 'review'], 'required'],
            [['created_at', 'user_customer_id', 'user_employee_id', 'vote'], 'integer'],
            [['review'], 'string'],
            [['user_customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_customer_id' => 'id']],
            [['user_employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_employee_id' => 'id']],
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
            'user_customer_id' => 'User Customer ID',
            'user_employee_id' => 'User Employee ID',
            'vote' => 'Vote',
            'review' => 'Review',
        ];
    }

    /**
     * Gets query for [[UserCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCustomer()
    {
         return $this->hasOne(Users::className(), ['id' => 'user_customer_id']);
    }

    /**
     * Gets query for [[UserEmployee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserEmployee()
    {
         return $this->hasOne(Users::className(), ['id' => 'user_employee_id']);
    }
}
