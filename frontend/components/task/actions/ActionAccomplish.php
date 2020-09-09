<?php

namespace frontend\components\task\actions;

use frontend\models\Task;
use frontend\models\User;

class ActionAccomplish extends AbstractAction
{
    public const ACTION_CODE = 20;
    public const ACTION_NAME = "Завершить";
    public const REQUIRED_ROLE = User::ROLE_CUSTOMER_CODE;
    public const TASK_STATUS_AFTER_ACTION = Task::STATUS_ACCOMPLISHED_CODE;
    public const TASK_STATUS_BEFORE_ACTION = Task::STATUS_PROCESSING_CODE;
}
