<?php

namespace frontend\components\task;

use frontend\components\helpers\Checker;
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

    public function getNextAction(): AbstractAction
    {
        try {
            $actions = $this->getPossibleActions();

            foreach ($actions as $key => $action) {
                if ($action->checkRights($this->currentUserRole)) {
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
        if (Checker::authUserRespondedToTask($this->task->id)) {
            $this->actionButtonVisibility = false;
            return;
        }
        $this->actionButtonVisibility = true;
    }

    public function __construct(Task $task, int $currentUserRole)
    {
        $this->actionCancel = new ActionCancel();
        $this->actionAccomplish = new ActionAccomplish();
        $this->actionRespond = new ActionRespond();
        $this->actionRefuse = new ActionRefuse();

        $this->task = $task;
        $this->currentTaskStatusCode = $task['current_status'];
        $this->currentUserRole = $currentUserRole;
        $this->setActionButtonVisibility();
    }


    public function getActionButtonVisibility(): bool
    {
        return $this->actionButtonVisibility;
    }
}
