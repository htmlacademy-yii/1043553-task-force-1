<?php

namespace frontend\controllers;

use App\Task;
use frontend\components\task\actions\ActionAccomplish;
use frontend\components\task\actions\ActionCancel;
use frontend\components\task\actions\ActionRefuse;
use frontend\components\task\actions\ActionRespond;
use frontend\controllers\parentControllers\SecuredController;

class TaskActionController extends SecuredController
{
    public function actionRespond($taskId)
    {
        $this->enableCsrfValidation = false;
        $actionRespond = new ActionRespond($taskId);

        return $actionRespond->processAction();
    }

    public function actionAccomplish($taskId)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->enableCsrfValidation = false;
        $actionAccomplish = new ActionAccomplish($taskId);

        return $actionAccomplish->processAction();
        //return $this->redirectBack();
    }

    public function actionRefuse($taskId)
    {
        $actionRefuse = new ActionRefuse($taskId);
        $actionRefuse->processAction();
        return $this->redirectBack();
    }

    public function actionCancel($taskId)
    {
        $actionCancel = new ActionCancel($taskId);
        $actionCancel->processAction();

        return $this->redirectBack();
    }
}
