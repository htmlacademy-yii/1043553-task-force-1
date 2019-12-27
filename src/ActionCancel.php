<?php

namespace TaskForce;

class ActionCancel extends AbstractAction
{
    public function __construct()
    {
        $this->actionName = "Отменить";
        $this->actionCode = "actionCancel";
        $this->requiredRole = Task::ROLE_CUSTOMER;
    }
}
