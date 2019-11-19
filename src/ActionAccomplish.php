<?php


namespace TaskForce;


class ActionAccomplish
{
    public static function getActionName()
    {
        return "Завершить";
    }

    public static function getActionCode()
    {
        return "ActionAccomplish";
    }

    public static function getRights($customerId, $userId)
    {
        if ($customerId === $userId) {
            return true;
        } else {
            return false;
        }
    }
}
