<?php

namespace TaskForce;

class ActionRespond extends AbstractAction
{

    public function __construct()
    {
        $this->actionName = "Откликнутся";
        $this->actionCode = "actionRespond";
    }

    public function checkRights($customerId, $employeeId, $userId)
    {
        return $employeeId === $userId;
    }
}
