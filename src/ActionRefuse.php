<?php

namespace TaskForce;

class ActionRefuse extends AbstractAction
{
    public const ACTION_CODE = 30;
    private const ACTION_NAME = "Отказаться";

    public function __construct()
    {
        $this->actionName = self::ACTION_NAME;
        $this->actionCode = self::ACTION_CODE;
        $this->requiredRole = Task::ROLE_EMPLOYEE;
    }
}
