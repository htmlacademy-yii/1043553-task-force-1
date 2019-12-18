<?php


namespace TaskForce;


class ActionCancel extends AbstractAction
{
    protected $actionName = "Отменить";
    protected $actionCode = "actionCancel";

    public function checkRights($customerId, $employeeId, $userId)
    {
        return $customerId === $userId;
    }
}
