<?php

namespace TaskForce;

use TaskForce\Exception\TaskException;

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
        try {
            Task::checkRole($role);
            return $this->requiredRole === $role;
        } catch (TaskException $e) {
            error_log("Error:" . $e->getMessage());
        }
        return false;
    }
}
