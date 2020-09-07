<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\SecuredController;
use yii\helpers\Url;

class LogoutController extends SecuredController
{
    public function actionIndex()
    {
        \Yii::$app->user->logout();

        return $this->redirect(Url::toRoute(['/ ']));
    }
}