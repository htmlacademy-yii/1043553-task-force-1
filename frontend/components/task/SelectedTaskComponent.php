<?php

namespace frontend\components\task;

use frontend\components\helpers\Checker;
use frontend\components\response\ResponseViewComponent;
use frontend\components\response\ResponseVisibilityComponent;
use frontend\components\traits\QueriesTrait;
use frontend\models\Task;
use frontend\models\User;
use Yii;

class SelectedTaskComponent
{
    use QueriesTrait;

    private Task $task;
    private int $taskCreatorId;
    private bool $showResponses;
    private ResponseViewComponent $responseViewComponent;
    private ResponseVisibilityComponent $responseVisibilityComponent;
    private TaskActionComponent $taskActionComponent;
    private int $userRole;

    public function __construct()
    {
        $selectedTaskId = (int)\Yii::$app->request->get('id');
        $this->task = $this->getTaskWithResponsesCategoriesFiles($selectedTaskId);
        $this->taskCreatorId = (int)$this->task['user_customer_id'];
        $this->userRole = Checker::authorisedUserIsTaskCreator($this->task);
        $this->responseViewComponent = new ResponseViewComponent($this->task);
        $this->responseVisibilityComponent = new ResponseVisibilityComponent($this->task);
        $this->taskActionComponent = new TaskActionComponent($this->task['current_status'], $this->userRole);
    }

    public function getCustomerData(): User
    {
        $customer = $this->findUsersQuery()
            ->where(['users.id' => $this->taskCreatorId])
            ->one();

        $customer['photo'] = self::findUsersPhoto($this->task['user_customer_id']);

        return $customer;
    }

    public function getUserRole(): int
    {
        return $this->userRole;
    }

    public function getResponseVisibility(): bool
    {
        return $this->responseVisibilityComponent->getResponseVisibility();
    }

    public function getTaskResponses(): array
    {
        return $this->responseViewComponent->taskResponses ?? [];
    }

    public function getTaskAction(): string
    {
        return $this->taskActionComponent->getNextAction()->getActionName();
    }

    public function getTask(): Task
    {
        return $this->task;
    }
}
