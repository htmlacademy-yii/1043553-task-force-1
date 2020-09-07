<?php

namespace frontend\components\task;

use frontend\models\Task;
use frontend\components\task\actions\AbstractAction;
use frontend\components\task\actions\ActionAccomplish;
use frontend\components\task\actions\ActionCancel;
use frontend\components\task\actions\ActionRefuse;
use frontend\components\task\actions\ActionRespond;

class TaskStatusComponent
{
    private $currentTaskStatusCode;

    public function getPossibleTaskStatuses(): array
    {
        $statuses = [
            Task::STATUS_NEW_CODE => [
                Task::STATUS_CANCELLED_CODE => Task::STATUS_CANCELLED_NAME,
                Task::STATUS_PROCESSING_CODE => Task::STATUS_PROCESSING_NAME
            ],

            Task::STATUS_PROCESSING_CODE => [
                Task::STATUS_ACCOMPLISHED_CODE => Task::STATUS_ACCOMPLISHED_NAME,
                Task::STATUS_FAILED_CODE => Task::STATUS_FAILED_NAME
            ]
        ];

        if ($statuses[$this->currentTaskStatusCode]) {
            return $statuses[$this->currentTaskStatusCode];
        }

        throw new TaskException(Task::GET_POSSIBLE_STATUSES_EXCEPTION);
    }


    public function predictTaskStatus(AbstractAction $action): array
    {
        $statuses = [
            ActionCancel::ACTION_CODE => [Task::STATUS_CANCELLED_CODE => Task::STATUS_CANCELLED_NAME],
            ActionRespond::ACTION_CODE => [Task::STATUS_PROCESSING_CODE => Task::STATUS_PROCESSING_NAME],
            ActionAccomplish::ACTION_CODE => [Task::STATUS_ACCOMPLISHED_CODE => Task::STATUS_ACCOMPLISHED_NAME],
            ActionRefuse::ACTION_CODE => [Task::STATUS_FAILED_CODE => Task::STATUS_FAILED_NAME]
        ];

        $actionCode = $action->getActionCode();
        $possibleStatus = $statuses[$actionCode] ?? false;

        if ($possibleStatus) {
            return $possibleStatus;
        }

        throw new TaskException(Task::PREDICT_STATUS_EXCEPTION);
    }

    public function updateCurrentStatus(int $role): void
    {
        try {
            $action = $this->getNextAction($role);
            $status = $this->predictTaskStatus($action);
            $this->currentTaskStatusCode = array_key_first($status);
        } catch (TaskException $e) {
            error_log(Task::SET_CURRENT_STATUS_EXCEPTION . $e->getMessage());
        }
    }
}
