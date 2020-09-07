<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\UnsecuredController;
use frontend\models\forms\UserLoginForm;
use Yii;

class LandingController extends UnsecuredController
{
    public $layout = 'landing';
    public UserLoginForm $model;

    public function actionIndex()
    {
        if (Yii::$app->request->getIsPost()) {
            return \Yii::$app->loginComponent->login($this->model);
        }
        $data = \Yii::$app->landingComponent->getDataForLandingPage();

        return $this->render('index', $data);
    }

    public function beforeAction($action)
    {
        $this->model = new UserLoginForm();
        $this->enableCsrfValidation = false;

        return parent::beforeAction($action);
    }
}
