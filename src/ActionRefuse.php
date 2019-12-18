<?php


namespace TaskForce;


class ActionRefuse extends AbstractAction
{
    protected $actionName = "Отказаться";
    protected $actionCode = "actionRefuse";

    public function checkRights($customerId, $employeeId, $userId)
    {
        return $employeeId === $userId;
    }
}
