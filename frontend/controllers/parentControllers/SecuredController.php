<?php

namespace frontend\controllers\parentControllers;

use frontend\components\traits\QueriesTrait;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;

class SecuredController extends Controller
{
    use QueriesTrait;

    public $userName;
    public $userPhoto;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'],
                        'denyCallback' => function ($rule, $action) {
                            return $this->redirect(Url::toRoute(['/ ']));
                        },
                    ]
                ]
            ]
        ];
    }

    public function beforeAction($action)
    {
        $userId = Yii::$app->user->getId();
        if ($userId) {
            $this->userName = self::findUserName($userId);
            $this->userPhoto = self::findUsersPhoto($userId);
        }

        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }
}