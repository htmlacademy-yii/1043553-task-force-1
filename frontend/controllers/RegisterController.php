<?php

namespace frontend\controllers;

use frontend\components\RegisterComponent;
use frontend\models\forms\RegisterForm;

class RegisterController extends UnsecuredController
{
    public function actionIndex()
    {
        $model = new RegisterForm();

        if (RegisterComponent::register($model)) {
             return $this->redirect('/tasks');
        }

        return $this->render('index', RegisterComponent::getDataForRegisterPage($model));
    }
}
