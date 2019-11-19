<?php


namespace TaskForce;


class ActionRefuse
{
    public static function getActionName()
    {
        return "Отказаться";
    }

    public static function getActionCode()
    {
        return "ActionRefuse";
    }

    public static function getRights($employeeId, $userId)
    {
        if ($employeeId === $userId) {
            return true;
        } else {
            return false;
        }
    }
}
