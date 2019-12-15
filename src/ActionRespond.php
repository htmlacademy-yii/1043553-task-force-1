<?php


namespace TaskForce;


class ActionRespond extends AbstractAction
{
    public function getActionName()
    {
        return "Откликнутся";
    }

    public function getActionCode()
    {
        return "ActionRespond";
    }

    public function checkRights($customerId, $employeeId, $userId)
    {
        if ($employeeId === $userId) {
            return true;
        } else {
            return false;
        }
    }
}
