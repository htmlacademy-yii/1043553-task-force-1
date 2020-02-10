<?php


namespace frontend\controllers;


use frontend\models\Tasks;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $data = (new Tasks())->getDataForTasksPage();

        return $this->render('browse', ["data" => $data]);
    }
}