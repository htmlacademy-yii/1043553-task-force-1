<?php


namespace TaskForce;


class ActionAccomplish extends AbstractAction
{
    protected $actionName = "Завершить";
    protected $actionCode = "actionAccomplish";

    public function checkRights($customerId, $employeeId, $userId)
    {
        if ($customerId === $userId) {
            return true;
        } else {
            return false;
        }
    }
}
