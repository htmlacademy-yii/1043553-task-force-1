<?php


namespace TaskForce;


class ActionRefuse extends AbstractAction
{
    protected $actionName = "Отказаться";
    protected $actionCode = "actionRefuse";

    public function checkRights($customerId, $employeeId, $userId)
    {
        if ($employeeId === $userId) {
            return true;
        } else {
            return false;
        }
    }
}
