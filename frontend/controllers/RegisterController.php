<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\UnsecuredController;
use frontend\models\forms\RegisterForm;

class RegisterController extends UnsecuredController
{
    public function actionIndex()
    {
        $model = new RegisterForm();
        if (\Yii::$app->registerComponent->register($model)) {
             return $this->redirect('/tasks');
        }

        $data = \Yii::$app->registerComponent->getDataForRegisterPage($model);

        return $this->render('index', $data);
    }
}
