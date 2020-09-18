<?php

namespace frontend\components\task\actions;

use frontend\components\response\ResponseCreateComponent;
use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;

class ActionRespond extends AbstractAction
{
    public const ACTION_CODE = 10;
    public const ACTION_NAME = "Откликнутся";
    public const REQUIRED_ROLE = User::ROLE_EMPLOYEE_CODE;
    public const TASK_STATUS_AFTER_ACTION = Task::STATUS_NEW_CODE;
    public const TASK_STATUS_BEFORE_ACTION = Task::STATUS_NEW_CODE;

    public function processAction(): array
    {
        if ($this->userIsAllowedToProcessAction() && Response::authUserHaveNotRespondedToTask($this->task->id)) {
            $responseCreateComponent = new ResponseCreateComponent($this->task->id);
            return $responseCreateComponent->create();
            //ResponseCreateComponent::createResponse($this->task->id);
        }
    }
}
