<?php

namespace frontend\controllers;

use frontend\components\user\AuthUserComponent;
use frontend\controllers\parentControllers\SecuredController;
use frontend\models\User;
use yii\helpers\Url;

class LogoutController extends SecuredController
{
    public function actionIndex()
    {
        AuthUserComponent::logout();

        return $this->redirect(Url::toRoute(['/ ']));
    }
}