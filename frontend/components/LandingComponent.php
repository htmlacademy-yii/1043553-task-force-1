<?php

namespace frontend\components;

use frontend\components\helpers\TimeOperations;
use frontend\models\forms\UserLoginForm;
use frontend\components\traits\QueriesTrait;
use frontend\models\User;
use Yii;
use yii\widgets\ActiveForm;

class LandingComponent
{
    use QueriesTrait;

    public static function getDataForLandingPage(): array
    {
        $query = self::findNewTasksWithCategoryCityQuery();
        $tasks = $query->orderBy(['tasks.created_at' => SORT_DESC])->limit(4)->all();

        foreach ($tasks as &$task) {
            $task['created_at'] = TimeOperations::timePassed($task['created_at']);
            $task['description'] = self::makeStringShorter($task['description'], 70);
        }

        return ['tasks' => $tasks];
    }

    public static function login(UserLoginForm $userLoginForm): array
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = \Yii::$app->request;
        $userLoginForm->load($request->post());
        $user = $userLoginForm->getUser();

        return self::processLogin($request, $userLoginForm, $user);
    }

    private static function processLogin(Yii\Web\Request $request, UserLoginForm $userLoginForm, ?User $user): array
    {
        if ($request->isAjax && ActiveForm::validate($userLoginForm) == []) {
            return [
                'loginResult' => Yii::$app->user->login($user),
                'error' => $userLoginForm->getErrorMessage()
            ];
        }
        return ['loginResult' => false, 'error' => $userLoginForm->getErrorMessage()];
    }

    private static function makeStringShorter(string $string, $length)
    {
        return substr($string, 0, $length) . '...';
    }
}
