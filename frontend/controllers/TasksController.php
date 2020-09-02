<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\SecuredController;
use frontend\models\forms\TaskCreateForm;

class TasksController extends SecuredController
{
    public function actionIndex()
    {
        $data = \Yii::$app->taskViewComponent->getDataForTasksPage();

        return $this->render('index', $data);
    }

    public function actionShow(int $id)
    {
        $data = \Yii::$app->taskViewComponent->getDataForSelectedTaskPage($id);

        return $this->render('show', $data);
    }

    public function actionCreate()
    {
        $model = new TaskCreateForm();

        if (\Yii::$app->taskCreateComponent->createTask($model)) {
            $this->redirect('/tasks');
        }

        $data = \Yii::$app->taskCreateComponent->getDataForTaskCreatePage($model);

        return $this->render('create', $data);
    }
}
