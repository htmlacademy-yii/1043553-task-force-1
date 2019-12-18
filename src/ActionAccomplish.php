<?php


namespace TaskForce;


class ActionAccomplish extends AbstractAction
{
    protected $actionName = "Завершить";
    protected $actionCode = "actionAccomplish";

    public function checkRights($customerId, $employeeId, $userId)
    {
        return $customerId === $userId;
    }
}
