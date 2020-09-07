<?php

namespace frontend\components\response\actions;

use frontend\models\Response;

class ActionApprove extends AbstractAction
{
    public const ACTION_CODE = 10;

    public function __construct()
    {
        $this->statusAfterAction = Response::STATUS_APPROVED_CODE;
    }
}
