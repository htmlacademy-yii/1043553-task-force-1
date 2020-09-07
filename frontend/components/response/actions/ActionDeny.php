<?php

namespace frontend\components\response\actions;

use frontend\models\User;

class ActionApprove extends AbstractAction
{
    public const ACTION_CODE = 20;
    private const ACTION_NAME = "Завершить";
    public const REQUIRED_ROLE = User::ROLE_CUSTOMER_CODE;

    public function __construct()
    {
        $this->actionName = self::ACTION_NAME;
        $this->actionCode = self::ACTION_CODE;
        $this->requiredRoleCode = User::ROLE_CUSTOMER_CODE;
    }
}
