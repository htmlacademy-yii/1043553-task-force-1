<?php


namespace TaskForce;


class ActionRespond extends AbstractAction
{
    protected $actionName = "Откликнутся";
    protected $actionCode = "actionRespond";

    public function checkRights($customerId, $employeeId, $userId)
    {
        return $employeeId === $userId;
    }
}
