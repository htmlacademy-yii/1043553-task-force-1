<?php

namespace frontend\components\task\actions;

use frontend\components\task\TaskStatusComponent;
use frontend\models\Task;
use frontend\models\User;

class ActionCancel extends AbstractAction
{
    public const ACTION_CODE = 40;
    public const ACTION_NAME = "Отменить";
    public const REQUIRED_ROLE = User::ROLE_CUSTOMER_CODE;
    public const TASK_STATUS_AFTER_ACTION = Task::STATUS_CANCELLED_CODE;
    public const TASK_STATUS_BEFORE_ACTION = Task::STATUS_NEW_CODE;
}
