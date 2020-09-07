<?php

namespace frontend\components\task\actions;

use frontend\models\User;

class ActionRespond extends AbstractAction
{
    public const ACTION_CODE = 10;
    public const ACTION_NAME = "Откликнутся";
    public const REQUIRED_ROLE = User::ROLE_EMPLOYEE_CODE;

    public function __construct()
    {
        $this->requiredRoleCode = User::ROLE_EMPLOYEE_CODE;
    }
}
