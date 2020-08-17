<?php

namespace frontend\controllers;

use frontend\components\helpers\TimeOperations;
use frontend\components\LandingComponent;
use frontend\components\traits\TaskFiltersTrait;
use frontend\models\forms\UserLoginForm;
use Yii;
use yii\web\Controller;

class LandingController extends Controller
{
    public $layout = 'landing';
    public UserLoginForm $model;

    public function actionIndex()
    {
        $this->model = new UserLoginForm();


        if (LandingComponent::login($this->model)) {
            return $this->redirect('/tasks');
        }

        $data = LandingComponent::getDataForLandingPage($this->model);

         //$this->renderAjax('index', $data);

        return $this->render('index', $data, false, true);
    }
}

/*public function actionLogin()
    {
        $this->userLoginForm = new UserLoginForm();

        if (Yii::$app->request->getIsPost()) {
            $this->userLoginForm->load(Yii::$app->request->post());
            if ($this->userLoginForm->validate()) {
                Yii::$app->user->login($this->userLoginForm->getUser());
                return $this->redirect('/tasks');
            }
        }

        return $this->goHome();
    }*/