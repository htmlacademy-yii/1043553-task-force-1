<?php

namespace frontend\components;

use frontend\models\City;
use frontend\models\forms\RegisterForm;
use frontend\models\forms\UserLoginForm;
use Yii;
use yii\base\Component;

class RegisterComponent extends Component
{
    private const MOSCOW_ID = 1109;
    private const EMAIL_LABEL_DEFAULT_TEXT = 'Введите валидный адрес электронной почты';
    private const NAME_LABEL_DEFAULT_TEXT = 'Введите ваше имя и фамилию';
    private const PASSWORD_LABEL_DEFAULT_TEXT = 'Длина пароля от 8 символов';
    private const CITY_LABEL_DEFAULT_TEXT = 'Укажите город, чтобы находить подходящие задачи';


    public function getDataForRegisterPage(RegisterForm $model): array
    {
        $cities = City::getCities();
        $errors = $model->getErrors() ?? [];

        $previousValues = [
            'email' => $model->email ?? '',
            'name' => $model->name ?? '',
            'password' => $model->password ?? '',
            'city' => $model->city ?? self::MOSCOW_ID
            ];

        $inputLabelTexts = [
            'email' => $errors['email'][0] ?? self::EMAIL_LABEL_DEFAULT_TEXT,
            'name' => $errors['name'][0] ?? self::NAME_LABEL_DEFAULT_TEXT,
            'password' => $errors['password'][0] ?? self::PASSWORD_LABEL_DEFAULT_TEXT,
            'city' => $errors['city'][0] ?? self::CITY_LABEL_DEFAULT_TEXT
        ];

         return [
            'model' => $model,
            'cities' => $cities,
            'errors' => $errors,
            'values' => $previousValues,
            'inputLabelTexts' => $inputLabelTexts
         ];
    }

    public function register(RegisterForm $model): bool
    {
        $formData = Yii::$app->request->post() ?? [];

        if (!$model->load($formData) or !$model->validate()) {
             return false;
        }

        if ($model->register()) {
             return self::loginAfterRegistration($model);
        }
         return false;
    }

    private function loginAfterRegistration(RegisterForm $RegisterForm): bool
    {
        $loginForm = new UserLoginForm();
        $loginForm->email = $RegisterForm->email;
        $loginForm->password = $RegisterForm->password;
        $user = $loginForm->getUser();

        return Yii::$app->user->login($user);
    }
}
