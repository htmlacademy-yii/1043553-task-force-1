<?php
include_once "vendor/autoload.php";
use TaskForce\Task;
use TaskForce\TaskException\TaskException;

$task = new Task(1, 2, '10.12.2019');

$employeeId = $task->getEmployeeId();
$customerId = $task->getCustomerId();

$combinations = [
    $employeeId,$employeeId,

    $employeeId,$customerId,

    $customerId
];
try {
    foreach ($combinations as $key => $id) {
        echo $task->getCurrentStatus() . PHP_EOL;
        echo "employee" . PHP_EOL;
        print_r($task->getAction($customerId, $employeeId, $employeeId));
        echo "customer" . PHP_EOL;
        print_r($task->getAction($customerId, $employeeId, $customerId));
        $task->setCurrentStatus($customerId, $employeeId, $id);
    }
} catch (TaskException $e) {
    error_log("Ошибка: " . $e->getMessage());
}
