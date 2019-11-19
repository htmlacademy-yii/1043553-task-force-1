<?php


namespace TaskForce;


abstract class AbstractAction
{
    abstract public static function getActionName();
    abstract public static function getActionCode();
    abstract public static function getRights($userId1, $userId2);
}