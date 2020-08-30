<?php

namespace frontend\models\forms;

use frontend\models\Category;
use frontend\models\Task;
use Yii;
use yii\base\Model;

class TaskCreateForm extends Model
{
    public $name;
    public $description;
    public $category;
    public $address;
    public $budget;
    public $expire;

    public function attributeLabels()
    {
        return [
            'name' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'address' => 'Локация',
            'budget' => 'Бюджет',
            'expire' => 'Срок исполнения'
        ];
    }

    public function rules()
    {
        return [
            [['name', 'description', 'category', 'address', 'budget', 'expire'], 'safe'],
            [['name', 'description', 'category', 'budget', 'expire'], 'required'],
            [['name', 'description', 'address'], 'string'],
            [['category'], 'exist', 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
            [['budget'], 'integer', 'min' => 1],
            [['expire'], 'date', 'format' => 'php:Y-m-d']
        ];
    }

    public function save()
    {
        $task = new Task();

        $task->user_customer_id = Yii::$app->user->getId();
        $task->current_status = Task::STATUS_NEW_CODE;

        $task->title = $this->name;
        $task->description = $this->description;
        $task->category_id = $this->category;
        //$task->address = $this->address;
        $task->budget = $this->budget;
        $task->deadline = $this->expire;

        return $task->save();
    }
}