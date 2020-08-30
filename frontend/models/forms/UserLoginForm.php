<?php

namespace frontend\models\forms;

use frontend\models\User;
use yii\base\Model;

class UserLoginForm extends Model
{
    public $email;
    public $password;
    private $user;

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'password' => 'Пароль'
        ];
    }

    public function rules()
    {
        return [
            [['email', 'password'], 'safe'],
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'wrong email or password');
            }
        }
    }

    public function getUser(): ?User
    {
        if ($this->user === null) {
            $this->user = User::findOne(['email' => $this->email]);
        }

        return $this->user;
    }

    public function getErrorMessage(): string
    {
        $post = \Yii::$app->request->post()['UserLoginForm'];
        $email = $post["email"] ?? null;
        $password = $post["password"] ?? null;

        if (!$email or !$password) {
            return 'Заполните поля Имейл и Пароль';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return 'Введите валидый имейл';
        }

        return 'Неверный имейл либо пароль';
    }
}
