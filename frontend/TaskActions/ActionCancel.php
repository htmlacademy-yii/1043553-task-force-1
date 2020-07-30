<?php

namespace frontend\TaskActions;

class ActionCancel extends AbstractAction
{
    public const ACTION_CODE = 40;
    private const ACTION_NAME = "Отменить";
    public function __construct()
    {
        $this->actionName = self::ACTION_NAME;
        $this->actionCode = self::ACTION_CODE;
        $this->requiredRole = Task::ROLE_CUSTOMER;
    }
}
