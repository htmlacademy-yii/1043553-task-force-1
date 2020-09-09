<?php

namespace frontend\components\response\actions;

use frontend\components\response\ResponseStatusComponent;
use frontend\components\task\TaskStatusComponent;
use frontend\models\Response;

class ActionApprove extends AbstractAction
{
    public const ACTION_CODE = 10;
    public const STATUS_AFTER_ACTION = Response::STATUS_APPROVED_CODE;

    public function processAction(): void
    {
        if ($this->userIsAllowedToProcessAction()) {
            ResponseStatusComponent::updateResponseStatus($this->response, $this->statusAfterAction);

            $actionDeny = new ActionDeny($this->response->id);
            $actionDeny->denyAllPendingResponses();

            TaskStatusComponent::setStatusProcessing($this->task, $this->response->user_employee_id);
        }
    }
}
