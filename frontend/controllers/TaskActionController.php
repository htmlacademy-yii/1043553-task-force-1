<?php

namespace frontend\controllers;

use frontend\components\task\actions\ActionAccomplish;
use frontend\components\task\actions\ActionCancel;
use frontend\components\task\actions\ActionRefuse;
use frontend\components\task\actions\ActionRespond;
use frontend\controllers\parentControllers\SecuredController;

class TaskActionController extends SecuredController
{
    public function actionRespond($taskId)
    {
        $actionRespond = new ActionRespond($taskId);
        $actionRespond->processAction();
        return $this->redirectBack();
    }

    public function actionAccomplish($taskId)
    {
        $actionAccomplish = new ActionAccomplish($taskId);
        $actionAccomplish->processAction();
        return $this->redirectBack();
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
