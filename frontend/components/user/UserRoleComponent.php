<?php

namespace frontend\components\user;

use frontend\components\helpers\Checker;
use frontend\components\traits\QueriesTrait;
use frontend\models\Task;
use frontend\models\User;

class UserRoleComponent
{
    use QueriesTrait;

    public static function detectUserRole(Task $task): int
    {
        if (User::idEqualAuthUserId($task->user_customer_id)) {
            return User::ROLE_CUSTOMER_CODE;
        }

        return User::ROLE_EMPLOYEE_CODE;
    }

    public static function authUserIsTaskEmployee(Task $task): bool
    {
        if ($task->user_employee_id) {
            return User::idEqualAuthUserId($task->user_employee_id);
        }

        return false;
    }

    public static function authUserIsTaskCustomer(Task $task): bool
    {
        return User::idEqualAuthUserId($task->user_customer_id);
    }

    public static function userIsTaskCustomer(int $userId, Task $task)
    {
        return $userId === (int)$task->user_customer_id;
    }

    public static function userIsTaskEmployee(int $userId, Task $task)
    {
        return $userId === (int)$task->user_employee_id;
    }
}
