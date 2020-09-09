<?php

namespace frontend\components\task\actions;

use frontend\models\Task;
use frontend\models\User;

class ActionRefuse extends AbstractAction
{
    public const ACTION_CODE = 30;
    public const ACTION_NAME = "Отказаться";
    public const REQUIRED_ROLE = User::ROLE_EMPLOYEE_CODE;
    public const TASK_STATUS_AFTER_ACTION = Task::STATUS_FAILED_CODE;
    public const TASK_STATUS_BEFORE_ACTION = Task::STATUS_PROCESSING_CODE;
}
