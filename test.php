<?php
include_once "vendor/autoload.php";
use TaskForce\Task;

$task = new Task(1, 2, '10.12.2019');
echo $task->getCurrentStatus().PHP_EOL;
echo "customer".PHP_EOL;
var_dump($task->getActions(1,2, 1));
echo "employee".PHP_EOL;
print_r($task->getActions(1,2, 2));

$task->setCurrentStatus($task::STATUS_PROCESSING);
echo $task->getCurrentStatus().PHP_EOL;
echo "customer".PHP_EOL;
print_r($task->getActions(1,2, 1));
echo "employee".PHP_EOL;
print_r($task->getActions(1,2, 2));

$task->setCurrentStatus($task::STATUS_ACCOMPLISHED);
echo $task->getCurrentStatus().PHP_EOL;
echo "customer".PHP_EOL;
print_r($task->getActions(1,2, 1));
echo "employee".PHP_EOL;
print_r($task->getActions(1,2, 2));

$task = new Task(1, 2, '10.12.2019');

$task->setCurrentStatus($task::STATUS_NEW);
$task->setCurrentStatus($task::STATUS_CANCELLED);
echo $task->getCurrentStatus().PHP_EOL;
echo "customer".PHP_EOL;
print_r($task->getActions(1,2, 1));
echo "employee".PHP_EOL;
print_r($task->getActions(1,2, 2));

$task = new Task(1, 2, '10.12.2019');

$task->setCurrentStatus($task::STATUS_NEW);
$task->setCurrentStatus($task::STATUS_PROCESSING);
$task->setCurrentStatus($task::STATUS_FAILED);
echo $task->getCurrentStatus().PHP_EOL;
echo "customer".PHP_EOL;
print_r($task->getActions(1,2, 1));
echo "employee".PHP_EOL;
print_r($task->getActions(1,2, 2));
