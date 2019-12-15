<?php


namespace TaskForce;


class ActionAccomplish extends AbstractAction
{
    public function getActionName()
    {
        return "Завершить";
    }

    public function getActionCode()
    {
        return "ActionAccomplish";
    }

    public function checkRights($customerId, $employeeId, $userId)
    {
        if ($customerId === $userId) {
            return true;
        } else {
            return false;
        }
    }
}
