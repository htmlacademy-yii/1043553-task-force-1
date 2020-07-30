<?php

namespace frontend\TaskActions;

abstract class AbstractAction
{
    protected $actionName;
    protected $actionCode;
    protected $requiredRole;

    public function getActionName(): string
    {
         return $this->actionName;
    }

    public function getActionCode(): string
    {
         return $this->actionCode;
    }

    public function checkRights(string $role): bool
    {
        return $this->requiredRole === $role;
    }
}
