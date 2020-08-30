<?php


namespace frontend\controllers;

use frontend\components\TaskComponent;
use frontend\models\forms\TaskCreateForm;

class TasksController extends SecuredController
{
    public function actionIndex()
    {
        return $this->render('index', TaskComponent::getDataForTasksPage());
    }

    public function actionShow(int $id)
    {
        return $this->render('show', TaskComponent::getDataForSelectedTaskPage($id));
    }

    public function actionCreate()
    {
        $model = new TaskCreateForm();

        if (TaskComponent::createTask($model)) {
            $this->redirect('/tasks');
        }
        return $this->render('create', TaskComponent::getDataForCreatePage($model));
    }
}
