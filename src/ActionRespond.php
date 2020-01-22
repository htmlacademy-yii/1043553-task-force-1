<?php

namespace TaskForce;

class ActionRespond extends AbstractAction
{
    public function __construct()
    {
        $this->actionName = "Откликнутся";
        $this->actionCode = "actionRespond";
        $this->requiredRole = Task::ROLE_EMPLOYEE;
    }
}
