<?php

namespace TaskForce;

class ActionRefuse extends AbstractAction
{

    public function __construct()
    {
        $this->actionName = "Отказаться";
        $this->actionCode = "actionRefuse";
        $this->requiredRole = Task::ROLE_EMPLOYEE;
    }
}
