<?php

namespace frontend\components\task\actions;

use frontend\models\User;

class ActionCancel extends AbstractAction
{
    public const ACTION_CODE = 40;
    public const ACTION_NAME = "Отменить";
    public const REQUIRED_ROLE = User::ROLE_CUSTOMER_CODE;

    public function __construct()
    {
        $this->requiredRoleCode = User::ROLE_CUSTOMER_CODE;
    }
}
