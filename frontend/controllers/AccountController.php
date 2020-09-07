<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\SecuredController;

class AccountController extends SecuredController
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}