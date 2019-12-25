<?php
include_once "vendor/autoload.php";
use TaskForce\Task;
use TaskForce\Exception\TaskException;

$combinations = [
    Task::ROLE_EMPLOYEE, Task::ROLE_EMPLOYEE,

    Task::ROLE_EMPLOYEE, Task::ROLE_EMPLOYEE,

    Task::ROLE_CUSTOMER, Task::ROLE_CUSTOMER,

    Task::ROLE_CUSTOMER, Task::ROLE_CUSTOMER
];

try {
    $task = new Task(1, 2, '10.12.2019');
    foreach ($combinations as $key => $role) {
        echo $task->getCurrentStatus() . PHP_EOL;
        echo "employee" . PHP_EOL;
        print_r($task->getAction(Task::ROLE_EMPLOYEE));
        echo "customer" . PHP_EOL;
        print_r($task->getAction(Task::ROLE_CUSTOMER));
        $task->setCurrentStatus($role);
    }
} catch (TaskException $e) {
    error_log("Ошибка: " . $e->getMessage());
}
