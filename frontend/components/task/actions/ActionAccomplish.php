<?php

namespace frontend\components\task\actions;

use frontend\models\User;

class ActionAccomplish extends AbstractAction
{
    public const ACTION_CODE = 20;
    private const ACTION_NAME = "Завершить";
    public function __construct()
    {
        $this->actionName = self::ACTION_NAME;
        $this->actionCode = self::ACTION_CODE;
        $this->requiredRoleCode = User::ROLE_CUSTOMER_CODE;
    }
}
