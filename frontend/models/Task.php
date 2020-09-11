<?php

namespace frontend\models;

use frontend\TaskActions\AbstractAction;
use frontend\TaskActions\ActionAccomplish;
use frontend\TaskActions\ActionCancel;
use frontend\TaskActions\ActionRefuse;
use frontend\TaskActions\ActionRespond;
use TaskForce\Exception\TaskException;

class Task extends \yii\db\ActiveRecord
{
    public const STATUS_NEW_CODE = 0;
    public const STATUS_CANCELLED_CODE = 2;
    public const STATUS_PROCESSING_CODE = 1;
    public const STATUS_ACCOMPLISHED_CODE = 3;
    public const STATUS_FAILED_CODE = 4;

    public const STATUS_NEW_NAME = "Новый";
    public const STATUS_CANCELLED_NAME = "Отменен";
    public const STATUS_PROCESSING_NAME = "В работе";
    public const STATUS_ACCOMPLISHED_NAME = "Выполнено";
    public const STATUS_FAILED_NAME = "Провалено";

    public const GET_POSSIBLE_STATUSES_EXCEPTION = 'Неизвестный индекc в функции getPossibleTaskStatuses';
    public const GET_POSSIBLE_ACTIONS_EXCEPTION = 'Неизвестный индекc в функции getPossibleActions';
    public const PREDICT_STATUS_EXCEPTION = 'Неизвестный индекc в функции predictTaskStatus';
    public const SET_CURRENT_STATUS_EXCEPTION = 'Невозможно поменять статус. Ошибка: ';

    public $image;
    public $city;
    public $category;

    public static function authorisedUserIsTaskCreator(Task $task): bool
    {
        return User::idEqualAuthUserId($task->user_customer_id);
    }

    public static function authorisedUserIsTaskEmployee(Task $task): bool
    {
        return User::idEqualAuthUserId($task->user_employee_id);
    }


    public static function tableName()
    {
        return 'tasks';
    }

    public function rules()
    {
         return [
            [
                [
                    'user_customer_id',
                    'user_employee_id',
                    'created_at',
                    'title',
                    'description',
                    'category_id',
                    'city_id',
                    'budget'
                ],
                'required'
            ],
            [
                [
                    'user_customer_id',
                    'user_employee_id',
                    'created_at',
                    'category_id',
                    'city_id',
                    'budget',
                    'current_status'
                ],
                'integer'
            ],
            [['description'], 'string'],
            [['deadline'], 'safe'],
            [['title', 'lat', 'lon', 'address'], 'string', 'max' => 50],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => 'id']
            ],
            [
                ['user_customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_customer_id' => 'id']
            ],
            [
                ['user_employee_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_employee_id' => 'id']
            ],
            [
                ['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
                'targetAttribute' => ['city_id' => 'id']
            ],
        ];
    }

    public function attributeLabels()
    {
         return [
            'id' => 'ID',
            'user_customer_id' => 'User Customer ID',
            'user_employee_id' => 'User Employee ID',
            'created_at' => 'Created At',
            'title' => 'Title',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'city_id' => 'City ID',
            'lat' => 'Lat',
            'lon' => 'Lon',
            'address' => 'Address',
            'budget' => 'Budget',
            'deadline' => 'Deadline',
            'current_status' => 'Current Status',
        ];
    }

    public function getCorrespondences()
    {
         return $this->hasMany(Correspondence::className(), ['task_id' => 'id']);
    }

    public function getResponses()
    {
         return $this->hasMany(Response::className(), ['task_id' => 'id']);
    }

    public function getCategory()
    {
         return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    public function getUserCustomer()
    {
         return $this->hasOne(User::className(), ['id' => 'user_customer_id']);
    }

    public function getUserEmployee()
    {
         return $this->hasOne(User::className(), ['id' => 'user_employee_id']);
    }

    public function getCity()
    {
         return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    public function getTasksFiles()
    {
         return $this->hasMany(TaskFile::className(), ['task_id' => 'id']);
    }

}
