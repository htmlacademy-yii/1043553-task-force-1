<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                '//' => '/',
                '/' => 'landing/index',
                'tasks' => 'tasks/index',
                'task/view/<id:\d+>' => 'tasks/show',
                'user/view/<id:\d+>' => 'users/show',
                'response/action/approve/<id:\d+>' => 'response-action/approve',
                'response/action/deny/<id:\d+>' => 'response-action/deny',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'taskViewComponent' => [
            'class' => 'frontend\components\task\TaskViewComponent',
        ],
        'taskCreateComponent' => [
            'class' => 'frontend\components\task\TaskCreateComponent',
        ],
        'userViewComponent' => [
            'class' => 'frontend\components\user\userViewComponent',
        ],
        'landingComponent' => [
            'class' => 'frontend\components\LandingComponent',
        ],
        'loginComponent' => [
            'class' => 'frontend\components\LoginComponent',
        ],
        'registerComponent' => [
            'class' => 'frontend\components\RegisterComponent',
        ],
    ],
];
