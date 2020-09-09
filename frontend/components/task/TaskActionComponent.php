<?php

namespace frontend\components\task;

use frontend\components\helpers\Checker;
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
        try {
            $actions = $this->getPossibleActions();

            foreach ($actions as $key => $action) {
                if ($action->userIsAllowedToProcessAction()) {
                    return $action;
                }
            }
        } catch (TaskException $e) {
            error_log($e->getMessage());
        }
    }

    private function getPossibleActions(): array
    {
        $actions = [
            Task::STATUS_NEW_CODE => [$this->actionCancel, $this->actionRespond],
            Task::STATUS_PROCESSING_CODE => [$this->actionAccomplish, $this->actionRefuse]
        ];
        if ($actions[$this->currentTaskStatusCode]) {
            return $actions[$this->currentTaskStatusCode];
        }

        throw new TaskException(Task::GET_POSSIBLE_ACTIONS_EXCEPTION);
    }

    private function setActionButtonVisibility(): void
    {
        if (Response::authUserHaveNotRespondedToTask($this->task->id)) {
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
