<?php

namespace TaskForce;

class ActionCancel extends AbstractAction
{
    public function __construct()
    {
        $this->actionName = "Отменить";
        $this->actionCode = "actionCancel";
    }

    public function checkRights($customerId, $employeeId, $userId)
    {
        return $customerId === $userId;
    }
}
