<?php


namespace TaskForce;


class ActionCancel extends AbstractAction
{
    protected $actionName = "Отменить";
    protected $actionCode = "actionCancel";

    public function checkRights($customerId, $employeeId, $userId)
    {
        if ($customerId === $userId) {
            return true;
        } else {
            return false;
        }
    }
}
