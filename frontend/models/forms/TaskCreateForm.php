<?php

namespace frontend\models\forms;

use frontend\components\LocationComponent;
use frontend\models\Category;
use frontend\models\Task;
use Yii;
use yii\base\Model;

class TaskCreateForm extends Model
{
    public $title;
    public $description;
    public $category;
    public $address;
    public $budget;
    public $deadline;

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'address' => 'Локация',
            'budget' => 'Бюджет',
            'deadline' => 'Срок исполнения'
        ];
    }

    public function rules()
    {
        return [
            [['title', 'description', 'category', 'address', 'budget', 'expire'], 'safe'],
            [['title', 'description', 'address', 'budget'], 'trim'],
            [['title', 'description', 'category', 'budget', 'deadline'], 'required'],
            [['title', 'description', 'address'], 'string'],
            [['category'], 'exist', 'targetClass' => Category::className(), 'targetAttribute' => ['category' => 'id']],
            [['budget'], 'integer', 'min' => 1],
            [['deadline'], 'date', 'format' => 'php:Y-m-d']
        ];
    }

    public function save()
    {
        $task = new Task();

        $task->user_customer_id = Yii::$app->user->getId();
        $task->current_status = Task::STATUS_NEW_CODE;

        $task->title = $this->title;
        $task->description = $this->description;
        $task->category_id = intval($this->category);
        $task->budget = intval($this->budget);
        $task->deadline = $this->deadline;
        $task->created_at = time();

        if ($this->address === '') {
            return $task->save(false);
        }

        try {
            $service = new LocationComponent($this->address);
            $coordinates = $service->getCoordinates();
            $task->lat = $coordinates['lat'];
            $task->lon = $coordinates['lon'];
            $task->address = $this->address;
            return $task->save(false);
        } catch (\Exception $e) {
            self::addError('address', $e->getMessage());
            return false;
        }
    }
}
