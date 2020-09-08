<?php

namespace frontend\controllers;

use frontend\components\response\ResponseStatusComponent;
use frontend\controllers\parentControllers\SecuredController;
use Yii;

class ResponseActionController extends SecuredController
{
    public function actionDeny($id, $userRole)
    {
        $responseStatusComponent = new ResponseStatusComponent($userRole, $id);
        $responseStatusComponent->denyResponse();
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionApprove($id, $userRole)
    {
        $responseStatusComponent = new ResponseStatusComponent($userRole, $id);
        $responseStatusComponent->approveResponse();
        return $this->redirect(Yii::$app->request->referrer);
    }
}
