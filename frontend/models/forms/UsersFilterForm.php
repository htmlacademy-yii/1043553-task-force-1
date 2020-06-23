<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\db\ActiveRecord;

/**
 * Signup form
 */
class UsersFilterForm extends ActiveRecord
{
    use CategoriesFieldsTrait;

    public $categories;
    public $additional;

    public bool $nowFree = false;
    public bool $nowOnline = false;
    public bool $reviews = false;
    public bool $remote = false;
    public bool $favorite = false;

    public string $search = "";

    public function additionalFields()
    {
        return [
            'nowFree' => 'Свободен',
            'nowOnline' => 'Сейчас онлайн',
            'reviews' => 'Есть отзывы',
            'remote' => 'Удаленная работа',
            'favorite' => 'в избранном'
        ];
    }

    public function periodFields()
    {
        return ['За день', 'За неделю', 'За месяц'];
    }

    public function searchField()
    {
        return 'Поиск по имени';
    }

    public function rules()
    {
        return [
            [['categories', 'additional', 'period', 'search'], 'safe'],
        ];
    }
}
