<?php

namespace frontend\api\controllers;

use frontend\models\Task;
use Yii;
use yii\rest\ActiveController;

class TasksController extends ActiveController
{
    public $modelClass = Task::class;

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['update'], $actions['delete'], $actions['create']);

        return $actions;
    }

    public function beforeAction($action)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }
}