<?php

namespace frontend\components\task;

use frontend\components\helpers\Checker;
use frontend\components\response\ResponseViewComponent;
use frontend\components\response\ResponseVisibilityComponent;
use frontend\components\traits\QueriesTrait;
use frontend\models\Task;
use frontend\models\User;

class SelectedTaskComponent
{
    use QueriesTrait;

    private Task $task;
    private int $taskCreatorId;
    private bool $showResponses;
    private ResponseViewComponent $responseViewComponent;
    private ResponseVisibilityComponent $responseVisibilityComponent;
    private TaskActionComponent $taskActionComponent;

    public function __construct()
    {
        $selectedTaskId = (int)\Yii::$app->request->get('id');
        $this->task = $this->getTaskWithResponsesCategoriesFiles($selectedTaskId);
        $this->taskCreatorId = (int)$this->task['user_customer_id'];
        $this->responseViewComponent = new ResponseViewComponent($this->task);
        $this->responseVisibilityComponent = new ResponseVisibilityComponent($this->task);
        $this->taskActionComponent = new TaskActionComponent($this->task);
    }

    public function getCustomerData(): User
    {
        $customer = $this->findUsersQuery()
            ->where(['users.id' => $this->taskCreatorId])
            ->one();

        $customer['photo'] = self::findUsersPhoto($this->task['user_customer_id']);

        return $customer;
    }

    public function getResponseVisibility(): bool
    {
        return $this->responseVisibilityComponent->getResponseVisibility();
    }

    public function getTaskResponses(): array
    {
        return $this->responseViewComponent->taskResponses ?? [];
    }

    public function getTaskAction(): int
    {
        return $this->taskActionComponent->getNextAction()->getActionCode();
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function getActionButtonVisibility(): bool
    {
        return $this->taskActionComponent->getActionButtonVisibility();
    }
}
