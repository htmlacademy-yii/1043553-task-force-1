<?php

namespace frontend\components\helpers;

use frontend\models\Task;
use frontend\models\User;

class Checker
{
    public static function roleIsCustomer(int $role): bool
    {
        return $role === User::ROLE_CUSTOMER_CODE;
    }
}
