<?php

namespace frontend\components\task\actions;

use frontend\models\User;

class ActionRespond extends AbstractAction
{
    public const ACTION_CODE = 10;
    private const ACTION_NAME = "Откликнутся";
    public function __construct()
    {
        $this->actionName = self::ACTION_NAME;
        $this->actionCode = self::ACTION_CODE;
        $this->requiredRoleCode = User::ROLE_EMPLOYEE_CODE;
    }
}
