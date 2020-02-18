<?php


namespace frontend\controllers;

use frontend\models\Users;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $usersData = (new Users())->getDataForEmployeesPage();
        return $this->render('users', ["usersData" => $usersData]);
    }
}