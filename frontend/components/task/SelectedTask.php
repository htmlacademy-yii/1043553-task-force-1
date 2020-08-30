<?php

namespace frontend\components\task;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;

class SelectedTask
{
    use QueriesTrait;

    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * @return User
     */
    public function getCustomerData(): User
    {
        //$customer = User::find()
        $customer = self::findUsersQuery()
            ->where(['users.id' => $this->task['user_customer_id']])
            ->one();

        $customer['photo'] = self::findUsersPhoto($this->task['user_customer_id']);

        return $customer;
    }

    /**
     * @return array
     *
     * Функция дополняет информацию об откликах необходимыми данными.
     */
    public function addDataToTaskResponses(): array
    {
        $responses = $this->task['responses'];

        return $this->addDataForEachResponse($responses);
    }

    /**
     * @param array $responses
     * @return array
     */
    private function addDataForEachResponse(array $responses): array
    {
        foreach ($responses as &$response) {
            $response = $this->addDataRelatedToResponse($response);
        }

        return $responses;
    }

    private function addDataRelatedToResponse(Response $response): Response
    {
        $response['userEmployee'] = self::findUserWithPhotosAndCategories($response['user_employee_id']);

        $response['userEmployee']['photo'] = self::findUsersPhoto($response['user_employee_id']);

        $response['your_price'] = $response['your_price'] ?? $this->task['budget'];

        $response['created_at'] = TimeOperations::timePassed($response['created_at']);

        return $response;
    }
}
