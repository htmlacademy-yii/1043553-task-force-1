<?php

namespace TaskForce;

abstract class AbstractAction
{
    protected $actionName;
    protected $actionCode;

    public function getActionName(): string
    {
         return $this->actionName;
    }

    public function getActionCode(): string
    {
         return $this->actionCode;
    }

    abstract public function checkRights($customerId, $employeeId, $userId): bool;
}
