<?php

namespace frontend\components\task;

use frontend\components\exception\TaskException;
use frontend\components\user\UserRoleComponent;
use frontend\models\Response;
use frontend\models\Task;
use frontend\components\task\actions\AbstractAction;
use frontend\components\task\actions\ActionAccomplish;
use frontend\components\task\actions\ActionCancel;
use frontend\components\task\actions\ActionRefuse;
use frontend\components\task\actions\ActionRespond;

class TaskActionComponent
{
    private ActionCancel $actionCancel;
    private ActionAccomplish $actionAccomplish;
    private ActionRespond $actionRespond;
    private ActionRefuse $actionRefuse;

    private int $currentTaskStatusCode;
    private int $currentUserRole;
    private Task $task;
    private bool $actionButtonVisibility;

    public const NO_ACTION_IS_AVAILABLE = 50;

    public function __construct(Task $task)
    {
        $this->actionCancel = new ActionCancel($task->id);
        $this->actionAccomplish = new ActionAccomplish($task->id);
        $this->actionRespond = new ActionRespond($task->id);
        $this->actionRefuse = new ActionRefuse($task->id);

        $this->task = $task;
        $this->currentTaskStatusCode = $task['current_status'];
        $this->currentUserRole = UserRoleComponent::detectUserRole($task);
        $this->setActionButtonVisibility();
    }

    public function getNextAction(): AbstractAction
    {
        $actions = $this->getPossibleActions();

        foreach ($actions as $key => $action) {
            if ($action->userIsAllowedToProcessAction()) {
                return $action;
            }
        }
    }

    private function getPossibleActions(): array
    {
        $actions = [
            Task::STATUS_NEW_CODE => [$this->actionCancel, $this->actionRespond],
            Task::STATUS_PROCESSING_CODE => [$this->actionAccomplish, $this->actionRefuse]
        ];
        if (isset($actions[$this->currentTaskStatusCode])) {
            return $actions[$this->currentTaskStatusCode];
        }

        throw new TaskException(Task::GET_POSSIBLE_ACTIONS_EXCEPTION);
    }

    private function setActionButtonVisibility(): void
    {
        if (TaskStatusComponent::taskIsCancelled($this->task) or TaskStatusComponent::taskIsFailed($this->task)) {
            $this->actionButtonVisibility = false;
            return;
        }

        if (Response::authUserHaveNotRespondedToTask($this->task->id)) {
            $this->actionButtonVisibility = true;
            return;
        }

        if (Task::authorisedUserIsTaskCreator($this->task)) {
            $this->actionButtonVisibility = true;
            return;
        }

        if (Task::authorisedUserIsTaskEmployee($this->task)) {
            $this->actionButtonVisibility = true;
            return;
        }

        $this->actionButtonVisibility = false;
    }

    public function getActionButtonVisibility(): bool
    {
        return $this->actionButtonVisibility;
    }
}
