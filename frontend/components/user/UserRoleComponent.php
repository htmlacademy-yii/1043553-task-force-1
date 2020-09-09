<?php

namespace frontend\components\user;

use frontend\components\helpers\Checker;
use frontend\models\Task;
use frontend\models\User;

class UserRoleComponent
{
    public static function detectUserRole(Task $task): int
    {
        if (User::idEqualAuthUserId($task->user_customer_id)) {
            return User::ROLE_CUSTOMER_CODE;
        }

        return User::ROLE_EMPLOYEE_CODE;
    }
}
