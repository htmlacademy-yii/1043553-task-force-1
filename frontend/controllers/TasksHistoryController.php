<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\SecuredController;

class TasksHistoryController extends SecuredController
{
    public function actionIndex()
    {
        $tasksHistory = \Yii::$app->authUserComponent->getAuthUserTasksHistory();
        return $this->render('index', ['tasks' => $tasksHistory]);
    }
}