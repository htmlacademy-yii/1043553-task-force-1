<?php

namespace frontend\components\response\actions;

use frontend\components\response\ResponseStatusComponent;
use frontend\components\user\UserRoleComponent;
use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;

abstract class AbstractAction
{
    protected int $statusAfterAction;
    protected Response $response;
    protected Task $task;

    public function processAction(): void
    {
        if ($this->userIsAllowedToProcessAction()) {
            $this->response->status = $this->statusAfterAction;
            $this->response->save();
        }
    }

    protected function userIsAllowedToProcessAction(): bool
    {
        $role = UserRoleComponent::detectUserRole($this->task);

        return $role === User::ROLE_CUSTOMER_CODE && ResponseStatusComponent::responseIsPending($this->response);
    }

    public function __construct(int $responseId)
    {
        $this->response = Response::findOne($responseId);
        $this->task = Task::findOne($this->response->task_id);
        $this->statusAfterAction = static::STATUS_AFTER_ACTION;
    }
}
