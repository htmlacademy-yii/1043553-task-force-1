<?php

namespace frontend\components;

use frontend\components\helpers\TimeOperations;
use frontend\models\forms\UserLoginForm;
use frontend\components\traits\QueriesTrait;
use Yii;
use yii\widgets\ActiveForm;

class LandingComponent
{
    use QueriesTrait;

    public static function getDataForLandingPage(UserLoginForm $userLoginForm)
    {
        $query = self::findNewTasksWithCategoryCityQuery();
        $tasks = $query->orderBy(['tasks.created_at' => SORT_DESC])->limit(4)->all();

        foreach ($tasks as &$task) {
            $task['created_at'] = TimeOperations::timePassed($task['created_at']);
            $task['description'] = substr($task['description'], 0, 70) . '...';
        }

        $errors = $userLoginForm->getErrors() ?? false;

         return ['tasks' => $tasks, 'errors' => $errors, 'model' => $userLoginForm];
    }

    public static function login(UserLoginForm $userLoginForm)
    {
        if (Yii::$app->request->getIsPost()) {
            $userLoginForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                return ActiveForm::validate($userLoginForm);
            }
            if ($userLoginForm->validate()) {
                Yii::$app->user->login($userLoginForm->getUser());
                return true;
            }
            return false;
        }
    }
}