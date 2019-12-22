<?php

namespace TaskForce;

class ActionAccomplish extends AbstractAction
{
    public function __construct()
    {
        $this->actionName = "Завершить";
        $this->actionCode = "actionAccomplish";
    }

    public function checkRights($customerId, $employeeId, $userId)
    {
        return $customerId === $userId;
    }
}
