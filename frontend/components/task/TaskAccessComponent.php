<?php

namespace frontend\components\task;

use frontend\models\Task;

class TaskAccessComponent
{
    public static function taskIsNotAccessible(int $taskId = null): bool
    {
        $selectedTaskId = $taskId ?? (int)\Yii::$app->request->get('id');
        $task = Task::findOne($selectedTaskId);
        return !Task::authUserCanAccessTask($task);
    }

}
