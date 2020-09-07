<?php

namespace frontend\components\task;

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
            echo 'ошибка бля';
            die;
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

    public function __construct(int $currentTaskStatusCode, int $currentUserRole)
    {
        $this->actionCancel = new ActionCancel();
        $this->actionAccomplish = new ActionAccomplish();
        $this->actionRespond = new ActionRespond();
        $this->actionRefuse = new ActionRefuse();

        $this->currentTaskStatusCode = $currentTaskStatusCode;
        $this->currentUserRole = $currentUserRole;
    }
}
