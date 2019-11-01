<?php
include_once "vendor/autoload.php";
use TaskForce\TaskStatus;

$taskStatus = new TaskStatus(1, 1, '10.12.2019');
//текущий статус новый
var_dump(
    $taskStatus->getCurrentStatus(),
    $taskStatus->getActions(),
    $taskStatus->getStatuses(),
    $taskStatus->predictStatus('cancel'),
    $taskStatus->predictStatus('accomplish'),
    $taskStatus->predictStatus('take'),
    $taskStatus->predictStatus('refuse')
);
