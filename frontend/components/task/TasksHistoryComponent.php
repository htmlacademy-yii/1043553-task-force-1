<?php

namespace frontend\components\task;

use frontend\components\exception\TaskException;
use frontend\components\response\ResponseViewComponent;
use frontend\components\response\ResponseVisibilityComponent;
use frontend\components\traits\QueriesTrait;
use frontend\components\user\UserRoleComponent;
use frontend\models\Category;
use frontend\models\Task;
use frontend\models\User;

class TasksHistoryComponent
{
    use QueriesTrait;

    private array $tasks;
    private int $userId;
    private string $status;

    public function __construct(string $status, int $userId)
    {
        $this->status = $status;
        $this->userId = $userId;
    }

    public function getTasksHistory(): array
    {
        $this->tasks = $this->getUserTasksInChosenStatus($this->status, $this->userId);
        $this->addDataToUserTaskHistory();
        return $this->tasks;
    }

    private function addDataToUserTaskHistory(): void
    {
        $tasksClone = [];
        foreach ($this->tasks as $key => $task) {
            $tasksClone[$key] = $task;
            $tasksClone[$key]['current_status'] = TaskStatusComponent::detectTaskStatus($task);
            $tasksClone[$key]['category'] = Category::findOne($task->category_id)->name;
            $tasksClone[$key]['partner'] = $this->findUserTaskPartner($task);
        }

        $this->tasks = $tasksClone;
    }

    private function findUserTaskPartner(Task $task): ?User
    {
        if (UserRoleComponent::userIsTaskCustomer($this->userId, $task)) {
            if ($task->user_employee_id) {
                return $this->findUserWithAvatarAndVote($task->user_employee_id);
            }
        }

        if (UserRoleComponent::userIsTaskEmployee($this->userId, $task)) {
            return $this->findUserWithAvatarAndVote($task->user_customer_id);
        }
        return null;
    }
}
