<?php


namespace TaskForce;


class ActionRespond
{
    public static function getActionName()
    {
        return "Откликнутся";
    }

    public static function getActionCode()
    {
        return "ActionRespond";
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
