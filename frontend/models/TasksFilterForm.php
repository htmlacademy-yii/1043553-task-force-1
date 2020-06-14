<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\ActiveRecord;


class TasksFilterForm extends ActiveRecord
{
    public $categories;
    public $additional;
    public $period;
    public $search;
    public $responses;
    public $cities;

    public function categoriesFields()
    {
        $categories = Categories::find()->all();
        $data = [];

        foreach ($categories as $category) {
            $data[$category['id']] = $category['name'];
        }

        return $data;
    }

    public function additionalFields()
    {
        return [
            'responses' => 'Без откликов',
            'cities' => 'Удаленная работа',
        ];
    }

    public function periodFields()
    {
        return ['За день', 'За неделю', 'За месяц'];
    }

    public function searchField()
    {
        return 'Поиск по названию';
    }

    public function rules()
    {
        return [
            [['categories', 'additional', 'period', 'search'], 'safe'],
        ];
    }
}
