<?php

namespace frontend\components\task;

use frontend\components\ResponseComponent;
use frontend\components\traits\QueriesTrait;
use frontend\models\Task;
use frontend\models\User;

class SelectedTaskComponent
{
    use QueriesTrait;

    private Task $task;
    private ResponseComponent $responseComponent;

    public function __construct()
    {
        $selectedTaskId = (int)\Yii::$app->request->get('id');
        $this->task = $this->getTaskWithResponsesCategoriesFiles($selectedTaskId);
        $this->responseComponent = new ResponseComponent();
    }

    public function getCustomerData(): User
    {
        $customer = $this->findUsersQuery()
            ->where(['users.id' => $this->task['user_customer_id']])
            ->one();

        $customer['photo'] = self::findUsersPhoto($this->task['user_customer_id']);

        return $customer;
    }

    public function getTaskResponses(): array
    {
        $responses = $this->task['responses'];

        return $this->responseComponent->addDataForEachResponse($responses);
    }

    public function getTask(): Task
    {
        return $this->task;
    }
}
