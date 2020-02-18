<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class UserPhotosFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\UserPhotos';
    public $dataFile = '@common/fixtures/data/UserPhotos.php';
}

// php yii fixture/generate usersCategories --count=20
// php yii fixture/load UsersCategories

// php yii fixture/generate userPhotos --count=20
// php yii fixture/load UserPhotos

