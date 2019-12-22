<?php

namespace TaskForce;

class ActionRefuse extends AbstractAction
{

    public function __construct()
    {
        $this->actionName = "Отказаться";
        $this->actionCode = "actionRefuse";
    }

    public function checkRights($customerId, $employeeId, $userId)
    {
        return $employeeId === $userId;
    }
}
