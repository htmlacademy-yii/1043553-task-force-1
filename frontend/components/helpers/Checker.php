<?php

namespace frontend\components\helpers;

use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;
use Yii;

class Checker
{
    public static function authorisedUserIsResponseCreator(Response $response): bool
    {
        return (int)$response->user_employee_id === Yii::$app->user->getId();
    }

    public static function authorisedUserIsTaskCreator(Task $task): bool
    {
        return (int)$task->user_customer_id === Yii::$app->user->getId();
    }

    public static function responseIsPending(Response $response): bool
    {
        return (int)$response->status === Response::STATUS_PENDING_CODE;
    }

    public static function roleIsCustomer(int $role): bool
    {
        return $role === User::ROLE_CUSTOMER_CODE;
    }

    public static function taskIsNotNew(Task $task): bool
    {
        return (int)$task->current_status !== Task::STATUS_NEW_CODE;
    }

    public static function authUserRespondedToTask($taskId): bool
    {
        $response = Response::find()
            ->where(['task_id' => $taskId])
            ->andWhere(['user_employee_id' => \Yii::$app->user->id])
            ->one();
        if ($response) {
            return true;
        }
        return false;
    }
}
