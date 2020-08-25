<?php

namespace frontend\components;

use frontend\models\City;
use frontend\models\forms\RegisterForm;
use Yii;

class RegisterComponent
{
    private const MOSCOW_ID = 1109;
    private const EMAIL_DEFAULT_DESCRIPTION = 'Введите валидный адрес электронной почты';
    private const NAME_DEFAULT_DESCRIPTION = 'Введите ваше имя и фамилию';
    private const PASSWORD_DEFAULT_DESCRIPTION = 'Длина пароля от 8 символов';
    private const CITY_DEFAULT_DESCRIPTION = 'Укажите город, чтобы находить подходящие задачи';
    /**
     * @param RegisterForm $model
     * @return array
     */
    public static function getDataForRegisterPage(RegisterForm $model): array
    {
        $cities = City::getCities();
        $errors = $model->getErrors() ?? [];

        $previousValues = [
            'email' => $model->email ?? '',
            'name' => $model->name ?? '',
            'password' => $model->password ?? '',
            'city' => $model->city ?? self::MOSCOW_ID
            ];

        $fieldsDescriptions = [
            'email' => $errors['email'][0] ?? self::EMAIL_DEFAULT_DESCRIPTION,
            'name' => $errors['name'][0] ?? self::NAME_DEFAULT_DESCRIPTION,
            'password' => $errors['password'][0] ?? self::PASSWORD_DEFAULT_DESCRIPTION,
            'city' => $errors['city'][0] ?? self::CITY_DEFAULT_DESCRIPTION
        ];

         return [
            'model' => $model,
            'cities' => $cities,
            'errors' => $errors,
            'values' => $previousValues,
            'fieldsDescriptions' => $fieldsDescriptions
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
