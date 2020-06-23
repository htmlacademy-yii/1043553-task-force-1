<?php

namespace frontend\models\forms;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\ActiveRecord;


class TasksFilterForm extends ActiveRecord
{
    use CategoriesFieldsTrait;

    public $categories;
    public $additional;
    public string $period = "";
    public string $search = "";
    public bool $responses = false;
    public bool $cities = false;

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
