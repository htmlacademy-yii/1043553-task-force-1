<?php

namespace frontend\components\task\actions;

use frontend\models\Response;

abstract class AbstractAction
{
    protected string $actionName;
    protected int $actionCode;
    protected int $requiredRoleCode;


    public function getActionName(): string
    {
        return static::ACTION_NAME;
    }

    public function getActionCode(): string
    {
        return static::ACTION_CODE;
    }

    public function checkRights(int $role): bool
    {
        return $role === static::REQUIRED_ROLE;
        //return $this->requiredRoleCode === $role;
    }
}
