<?php


namespace TaskForce;


abstract class AbstractAction
{
    abstract public function getActionName();
    abstract public function getActionCode();
    abstract public function checkRights($userId1, $userId2, $userId3);
}