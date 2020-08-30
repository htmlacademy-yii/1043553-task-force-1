<?php

namespace frontend\TaskActions;

class ActionRespond extends AbstractAction
{
    public const ACTION_CODE = 10;
    private const ACTION_NAME = "Откликнутся";
    public function __construct()
    {
        $this->actionName = self::ACTION_NAME;
        $this->actionCode = self::ACTION_CODE;
        $this->requiredRole = Task::ROLE_EMPLOYEE;
    }
}
