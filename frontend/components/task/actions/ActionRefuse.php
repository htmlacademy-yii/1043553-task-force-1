<?php

namespace frontend\components\task\actions;

use frontend\models\User;

class ActionRefuse extends AbstractAction
{
    public const ACTION_CODE = 30;
    public const ACTION_NAME = "Отказаться";
    public const REQUIRED_ROLE = User::ROLE_EMPLOYEE_CODE;

    public function __construct()
    {
        $this->requiredRoleCode = User::ROLE_EMPLOYEE_CODE;
    }
}
