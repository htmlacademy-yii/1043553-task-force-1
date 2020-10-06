<?php

namespace frontend\components\user;

use frontend\components\task\TasksHistoryComponent;
use frontend\components\traits\QueriesTrait;
use frontend\models\Task;
use frontend\models\User;

class AuthUserComponent
{
    use QueriesTrait;

    private array $tasks;

    public function getAuthUserTasksHistory(): array
    {
        $status = $this->getStatusParameterValue();
        $tasksHistory = new TasksHistoryComponent($status, \Yii::$app->user->getId());
        return $tasksHistory->getTasksHistory();
    }

    private function getStatusParameterValue()
    {
        return \Yii::$app->request->get()['status'] ?? Task::STATUS_PROCESSING;
    }

    public function updateAuthUserProfile()
    {
        //update
    }

    public static function logout(): void
    {
        $user = User::findOne(\Yii::$app->user->getId());
        $user->last_active = time();
        $user->update(false);
        \Yii::$app->user->logout();
    }
}
