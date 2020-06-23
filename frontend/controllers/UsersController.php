<?php


namespace frontend\controllers;

use frontend\models\Users;
use frontend\models\UsersFilterForm;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $model = new UsersFilterForm();
        $data = (new Users())->getDataForUsersPage($model);
        return $this->render('users', ["data" => $data, 'model' => $model ]);
    }
}