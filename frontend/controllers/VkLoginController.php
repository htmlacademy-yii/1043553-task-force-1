<?php

namespace frontend\controllers;

use frontend\components\VkComponent;
use frontend\controllers\parentControllers\UnsecuredController;

class VkLoginController extends UnsecuredController
{
    public function actionIndex($code)
    {
        $vkClient = new VkComponent($code);
        $vkUser = $vkClient->authorizeUserThroughVkAndGetInfo();
        \Yii::$app->loginComponent->loginVkUser($vkUser);

        return $this->redirect('/tasks');
    }
}
