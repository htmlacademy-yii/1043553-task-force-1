<?php

namespace frontend\components\task\actions;

use frontend\components\task\TaskStatusComponent;
use frontend\components\user\UserRoleComponent;
use frontend\models\Task;

abstract class AbstractAction
{
    protected string $actionName;
    protected int $actionCode;
    protected int $requiredRoleCode;
    protected int $statusAfterAction;
    protected int $statusBeforeAction;
    protected Task $task;

    protected const NO_RIGHTS_EXCEPTION = 'у вас нет прав для выполнения этого действия';

    public function __construct(int $taskId)
    {
        $this->actionName = static::ACTION_NAME;
        $this->actionCode = static::ACTION_CODE;
        $this->requiredRoleCode = static::REQUIRED_ROLE;
        $this->statusAfterAction = static::TASK_STATUS_AFTER_ACTION;
        $this->statusBeforeAction = static::TASK_STATUS_BEFORE_ACTION;

        $this->task = Task::findOne($taskId);
    }

    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function getActionCode(): int
    {
        return $this->actionCode;
    }

    public function userIsAllowedToProcessAction(): bool
    {
        $role = UserRoleComponent::detectUserRole($this->task);
        $taskStatus = (int)$this->task->current_status;
        return $role === $this->requiredRoleCode && $taskStatus === $this->statusBeforeAction;
    }

    public function processAction(): array
    {
        if ($this->userIsAllowedToProcessAction()) {
            return [
                'result' => TaskStatusComponent::updateTaskStatus($this->task, $this->statusAfterAction),
                'errors' => null
            ];
        }

        return [
            'result' => false,
            'errors' => self::NO_RIGHTS_EXCEPTION,
        ];
    }
}
