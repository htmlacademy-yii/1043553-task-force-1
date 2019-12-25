<?php

namespace TaskForce;

class ActionAccomplish extends AbstractAction
{
    public function __construct()
    {
        $this->actionName = "Завершить";
        $this->actionCode = "actionAccomplish";
        $this->requiredRole = Task::ROLE_CUSTOMER;
    }
}
