<?php

namespace frontend\controllers;

use frontend\components\YandexMapsComponent;
use frontend\controllers\parentControllers\SecuredController;

class AutocompleteController extends SecuredController
{
    public function actionIndex($address)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $yandexMapsClient = new YandexMapsComponent($address);

        return $yandexMapsClient->getAutocompleteValues();
    }
}
