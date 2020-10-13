<?php

namespace frontend\models\forms;

use frontend\models\Category;
use frontend\models\City;
use frontend\models\User;
use Yii;
use yii\base\Model;
use DateTime;

class UserProfileSettingsForm extends Model
{
    public $files;
    public $avatar;
    public $name;
    public $email;
    public $cityId;
    public $birthday;
    //public $timestampBirthday;
    public $description;
    public $categories = [];
    public $password;
    public $confirmedPassword;
    public $phone;
    public $skype;
    public $otherApp;
    public $notifications = [];
    public $settings = [];

    public function attributeLabels(): array
    {
        return [
            'avatar' => 'Сменить аватар',
            'name' => 'Ваше имя',
            'email' => 'email',
            'cityId' => 'Город',
            'birthday' => 'День рождения',
            'description' => 'Информация о себе',
            'categories' => 'categories',
            'password' => 'Новый пароль',
            'confirmedPassword' => 'Повтор пароля',
            'phone' => 'Телефон',
            'skype' => 'skype',
            'otherApp' => 'Другой мессенджер',
        ];
    }

    public function rules(): array
    {
        $today = new DateTime();

        return [
            [
                'files',
                'file',
                'extensions' => ['png', 'jpg', 'jpeg', 'gif'],
                'maxFiles' => 6,
                'message' => 'Ошибка при сохранении файлов',
            ],
            [
                ['notifications', 'settings'],
                'in',
                'range' => [true, false],
                'allowArray' => true,
            ],
            ['avatar', 'file', 'extensions' => ['png', 'jpg', 'jpeg', 'gif']],
            [['name', 'email'], 'trim'],
            [['name', 'email'], 'required', 'message' => 'Обязательное поле'],
            [
                'name',
                'unique',
                'targetClass' => User::class,
                'targetAttribute' => 'login',
                'filter' => function ($query) {
                    $query->andWhere([
                        '!=',
                        'user.login',
                        Yii::$app->user->identity->login,
                    ]);
                },
                'message' => 'Выбранное имя уже занято',
            ],
            ['email', 'email', 'message' => 'Не корректный тип email'],
            [
                'email',
                'unique',
                'targetClass' => User::class,
                'filter' => function ($query) {
                    $query->andWhere([
                        '!=',
                        'user.email',
                        Yii::$app->user->identity->email,
                    ]);
                },
                'message' => 'Указанный email уже используется',
            ],
            [['password', 'confirmedPassword'], 'string', 'min' => 6],
            ['password', 'compare', 'compareAttribute' => 'confirmedPassword'],
            [
                'birthday',
                'match',
                'pattern' => '/^\d{4}-\d{2}-\d{2}$/',
                'message' => 'Не корректный формат даты',
            ],
            [
                'birthday',
                'date',
                'format' => 'php:Y-m-d',
                'timestampAttribute' => 'timestampBirthday',
                'max' => $today->getTimestamp(),
                'maxString' => $today->format('Y-m-d'),
                'tooBig' => '{attribute} должен быть не позже {max}.',
            ],
            [
                'categories',
                'exist',
                'targetClass' => Category::class,
                'targetAttribute' => 'id',
                'allowArray' => true,
                'message' => 'Одна или несколько из выбранных вами специализаций не найдена',
            ],
            ['cityId', 'integer'],
            [
                'cityId',
                'exist',
                'targetClass' => City::class,
                'targetAttribute' => 'id',
                'message' => 'Город с указанным id не найден',
            ],
            ['description', 'string'],
            ['phone', 'string', 'length' => [11, 11]],
            ['otherApp', 'trim'],
            ['otherApp', 'string', 'min' => 1],
            ['skype', 'match', 'pattern' => '/^[0-9a-zA-Z]{3,}$/'],
        ];
    }

}
