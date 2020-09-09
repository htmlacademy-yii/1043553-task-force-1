<?php

namespace frontend\controllers;

use frontend\components\response\actions\ActionApprove;
use frontend\components\response\actions\ActionDeny;
use frontend\controllers\parentControllers\SecuredController;
use Yii;

class ResponseActionController extends SecuredController
{
    public function actionDeny($id)
    {
        $actionDeny = new ActionDeny($id);
        $actionDeny->processAction();
        return $this->redirectBack();
    }

    public function actionApprove($id)
    {
        $actionApprove = new ActionApprove($id);
        $actionApprove->processAction();
        return $this->redirectBack();
    }
}
