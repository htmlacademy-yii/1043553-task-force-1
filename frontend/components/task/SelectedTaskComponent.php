<?php

namespace frontend\components\task;

use frontend\components\ResponseComponent;
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
    private ResponseComponent $responseComponent;
    private TaskActionComponent $taskActionComponent;
    private int $userRole;

    public function __construct()
    {
        $selectedTaskId = (int)\Yii::$app->request->get('id');
        $this->task = $this->getTaskWithResponsesCategoriesFiles($selectedTaskId);
        $this->taskCreatorId = (int)$this->task['user_customer_id'];
        $this->detectUserRole();
        $this->responseComponent = new ResponseComponent($this->task);
        $this->taskActionComponent = new TaskActionComponent($this->task['current_status'], $this->userRole);
        $this->showResponses = $this->taskCreatorId === Yii::$app->user->getId();
    }

    public function getCustomerData(): User
    {
        $customer = $this->findUsersQuery()
            ->where(['users.id' => $this->taskCreatorId])
            ->one();

        $customer['photo'] = self::findUsersPhoto($this->task['user_customer_id']);

        return $customer;
    }

    public function showResponses(): bool
    {
        return $this->responseComponent->showResponses;
    }

    public function getTaskResponses(): array
    {
        return $this->responseComponent->taskResponses;
    }

    public function getTaskAction(): string
    {
        return $this->taskActionComponent->getNextAction()->getActionName();
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    private function detectUserRole()
    {
        if ($this->taskCreatorId == Yii::$app->user->getId()) {
            $this->userRole = User::ROLE_CUSTOMER_CODE;
            return;
        }
        $this->userRole = User::ROLE_EMPLOYEE_CODE;
    }
}
