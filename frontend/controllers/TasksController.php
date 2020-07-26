<?php


namespace frontend\controllers;

use frontend\components\TaskComponent;
use frontend\models\forms\TasksFilterForm;
use yii\web\Controller;
use TaskForce\Exception\TaskException;
use yii\web\NotFoundHttpException;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $model = new TasksFilterForm();
        $data = TaskComponent::getDataForTasksPage($model);

        return $this->render('index', ['data' => $data, 'model' => $model]);
    }

    public function actionShow(int $id)
    {
        $data = TaskComponent::getDataForSelectedTaskPage($id);
        return $this->render('show', $data);
    }
}