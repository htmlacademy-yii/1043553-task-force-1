<?php

namespace frontend\models\forms;

use frontend\models\City;
use Yii;
use yii\base\Model;
use frontend\models\User;

/**
 * Signup form
 */
class RegisterForm extends Model
{
    public string $name;
    public string $email;
    public string $password;
    public $city;

    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'city', 'password'], 'safe'],
            [['email', 'name', 'city', 'password'], 'required', 'message' => 'Пожалуста заполните поле {attribute} .'],
            [['email'], 'email', 'message' => 'Пожалуйста введите валидный имейл.'],
            [['email'], 'unique', 'targetClass' => User::className(), 'message' => 'Данный имейл уже используется'],
            [['name'], 'string', 'min' => 1, 'message' => 'Ведите правильное имя'],
            [['city'], 'integer'],
            [['city'], 'exist', 'targetClass' => City::className(), 'targetAttribute' => ['city' => 'id']],
            [['password'], 'string', 'min' => 8, 'message' => 'Пароль должен быть 8 или больше символов']
        ];
    }


    /**
     * @return bool
     */
    public function register(): bool
    {
        $user = new User();
        $user->attributes = $this->attributes;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->city_id = $this->city;
        $user->current_role = User::ROLE_CUSTOMER_CODE;
        $user->password_hash = password_hash($this->password, PASSWORD_DEFAULT);
        return $user->save(false);
    }


    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'email' => 'Электронная почта',
            'name' => 'Ваше имя',
            'city' => 'Город проживания',
            'password' => 'Пароль'
        ];
    }
}
