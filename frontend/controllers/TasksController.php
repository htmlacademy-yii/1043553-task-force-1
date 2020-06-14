<?php


namespace frontend\controllers;


use frontend\models\Categories;
use frontend\models\Tasks;
use frontend\models\TasksFilterForm;
use yii\web\Controller;
use TaskForce\Exception\TaskException;

class TasksController extends Controller
{
    public function actionIndex()
    {
        try {
            $model = new TasksFilterForm();
            $data = (new Tasks())->getDataForTasksPage($model);
        } catch (TaskException $e) {
            return 123;
        }




        return $this->render('browse', ["data" => $data, 'model' => $model]);
    }
}