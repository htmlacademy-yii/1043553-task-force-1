<?php

namespace frontend\components\task\actions;

use frontend\models\User;

class ActionRefuse extends AbstractAction
{
    public const ACTION_CODE = 30;
    private const ACTION_NAME = "Отказаться";

    public function __construct()
    {
        $this->actionName = self::ACTION_NAME;
        $this->actionCode = self::ACTION_CODE;
        $this->requiredRoleCode = User::ROLE_EMPLOYEE_CODE;
    }
}
