<?php

namespace frontend\controllers;

use frontend\components\task\TaskAccessComponent;
use frontend\controllers\parentControllers\SecuredController;
use frontend\models\forms\TaskAccomplishForm;
use frontend\models\forms\TaskCreateForm;
use frontend\models\forms\TaskResponseForm;

class TasksController extends SecuredController
{
    public TaskResponseForm $taskResponseForm;
    public TaskAccomplishForm $taskAccomplishForm;

    public function actionIndex()
    {
        $data = \Yii::$app->taskViewComponent->getDataForTasksPage();

        return $this->render('index', $data);
    }

    public function actionShow(int $id)
    {
        if (TaskAccessComponent::taskIsNotAccessible()) {
            return $this->redirectBack();
        }

        $this->taskResponseForm = new TaskResponseForm();
        $this->taskAccomplishForm = new TaskAccomplishForm();

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
