<?php

namespace frontend\components\response\actions;

use frontend\models\Response;

class ActionDeny extends AbstractAction
{
    public const ACTION_CODE = 20;

    public function __construct()
    {
        $this->statusAfterAction = Response::STATUS_REFUSED_CODE;
    }
}
