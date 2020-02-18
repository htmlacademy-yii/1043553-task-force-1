<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class UsersCategoriesFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\UsersCategories';
    public $dataFile = '@common/fixtures/data/UsersCategories.php';
}

