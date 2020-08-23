<?php

namespace frontend\controllers;

use yii\helpers\Url;
use yii\filters\AccessControl;
use yii\web\Controller;

class UnsecuredController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function () {
                            return $this->redirect(Url::toRoute(['/tasks']));
                        }
                    ],

                ]
            ]
        ];
    }
}