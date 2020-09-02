<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\SecuredController;

class AccountController extends SecuredController
{
    public function actionIndex()
    {
        \Yii::$app->user->logout();

        return $this->render('index');
    }
}