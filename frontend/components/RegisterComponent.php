<?php

namespace frontend\components;

use frontend\models\City;
use frontend\models\forms\RegisterForm;
use Yii;

class RegisterComponent
{
    /**
     * @param RegisterForm $model
     * @return array
     */
    public static function getDataForRegisterPage(RegisterForm $model): array
    {
        $cities = City::getCities();

        $previousValues = [
            'email' => $model->email ?? '',
            'name' => $model->name ?? '',
            'password' => $model->password ?? '',
            'city' => $model->city ?? ''
            ];

         return [
            'model' => $model,
            'cities' => $cities,
            'errors' => $model->getErrors() ?? [],
            'values' => $previousValues
         ];
    }

    /**
     * @param RegisterForm $model
     * @return bool
     */
    public static function register(RegisterForm $model): bool
    {
        $formData = Yii::$app->request->post() ?? [];

        if (!$model->load($formData) or !$model->validate()) {
             return false;
        }

        if ($model->register()) {
             return true;
        }

         return false;
    }

}