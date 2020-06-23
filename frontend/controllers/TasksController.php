<?php


namespace frontend\controllers;


use frontend\models\Categories;
use frontend\models\Task;
use frontend\models\forms\TasksFilterForm;
use yii\web\Controller;
use TaskForce\Exception\TaskException;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $model = new TasksFilterForm();
        $data = Task::getDataForTasksPage($model);

        return $this->render('browse', ["data" => $data, 'model' => $model]);
    }
}