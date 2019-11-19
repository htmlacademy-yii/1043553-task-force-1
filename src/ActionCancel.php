<?php


namespace TaskForce;


class ActionCancel extends AbstractAction
{
    public static function getActionName()
    {
        return "Отменить";
    }

    public static function getActionCode()
    {
        return "ActionCancel";
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
