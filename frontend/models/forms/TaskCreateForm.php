<?php

namespace frontend\models\forms;

use frontend\components\YandexMapsComponent;
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
    public $lat;
    public $lon;

    public function attributeLabels()
    {
        return [
            'title' => 'Мне нужно',
            'description' => 'Подробности задания',
            'category' => 'Категория',
            'address' => 'Локация',
            'budget' => 'Бюджет',
            'deadline' => 'Срок исполнения',
            'lat' => 'Долгота',
            'lon' => 'Широта'
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
            [['lat', 'lon'], 'number', 'numberPattern' => '/^\d{2}\.{1}\d{6}$/'],
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

        try {
            if ($this->address === '') {
                return $task->save(false);
            }

            $task->address = $this->address;

            if ($this->lat && $this->lon) {
                $task->lat = $this->lat;
                $task->lon = $this->lon;

                return $task->save(false);
            }

            $service = new YandexMapsComponent($this->address);
            $coordinates = $service->getCoordinates();
            $task->lat = $coordinates['lat'];
            $task->lon = $coordinates['lon'];

            return $task->save(false);
        } catch (\Exception $e) {
            self::addError('address', $e->getMessage());
            return false;
        }
    }
}
