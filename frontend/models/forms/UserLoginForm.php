<?php

namespace frontend\models\forms;

use frontend\models\User;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\Exception;

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

    public function getUser(): User
    {
        if ($this->user === null) {
            $this->user = User::findOne(['email' => $this->email]);
        }

        return $this->user;
    }
}