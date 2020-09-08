<?php

namespace frontend\components\response\actions;

use frontend\components\helpers\Checker;
use frontend\models\Response;

abstract class AbstractAction
{
    protected int $statusAfterAction;

    public function processAction(Response $response, int $role): void
    {
        if (Checker::roleIsCustomer($role) && Checker::responseIsPending($response)) {
            $response->status = $this->statusAfterAction;
            $response->save();
        }
    }
}
