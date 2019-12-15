<?php


namespace TaskForce;


class ActionRefuse extends AbstractAction
{
    public function getActionName()
    {
        return "Отказаться";
    }

    public function getActionCode()
    {
        return "ActionRefuse";
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
