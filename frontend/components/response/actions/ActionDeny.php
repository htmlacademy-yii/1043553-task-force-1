<?php

namespace frontend\components\response\actions;

use frontend\components\traits\QueriesTrait;
use frontend\models\Response;

class ActionDeny extends AbstractAction
{
    use QueriesTrait;

    public const ACTION_CODE = 20;
    public const STATUS_AFTER_ACTION = Response::STATUS_REFUSED_CODE;

    public function denyAllPendingResponses()
    {
        $pendingResponses = $this->findAllTaskPendingResponses($this->task->id) ?? [];

        foreach ($pendingResponses as $response) {
            $this->response = $response;
            $this->processAction();
        }
    }
}
