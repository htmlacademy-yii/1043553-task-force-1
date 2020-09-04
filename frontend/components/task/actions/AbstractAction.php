<?php

namespace frontend\components\task\actions;

abstract class AbstractAction
{
    protected string $actionName;
    protected int $actionCode;
    protected int $requiredRoleCode;

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function getActionCode(): string
    {
        return $this->actionCode;
    }

    public function checkRights(int $role): bool
    {
        return $this->requiredRoleCode === $role;
    }
}
