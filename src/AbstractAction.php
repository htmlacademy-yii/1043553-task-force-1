<?php

namespace TaskForce;

abstract class AbstractAction
{
    protected $actionName;
    protected $actionCode;

    public function getActionName()
    {
         return $this->actionName;
    }
    public function getActionCode()
    {
         return $this->actionCode;
    }
    abstract public function checkRights($customerId, $employeeId, $userId);
}
