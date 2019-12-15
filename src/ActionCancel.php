<?php


namespace TaskForce;


class ActionCancel extends AbstractAction
{
    public function getActionName()
    {
        return "Отменить";
    }

    public function getActionCode()
    {
        return "ActionCancel";
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
