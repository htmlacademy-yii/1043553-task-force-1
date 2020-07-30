<?php

namespace frontend\components\traits;

use frontend\components\helpers\TimeOperations;
use frontend\components\UserComponent;
use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;

trait SelectedTaskTrait
{
    use QueriesTrait;

    /**
     * @param $customerId
     * @return User
     */
    private static function getCustomerData($customerId): User
    {
        $customer = User::find()
            ->joinWith('tasks')
            ->where(['users.id' => $customerId])
            ->one();

        $customer['photo'] = self::findUsersPhoto($customerId);

        return $customer;
    }

    /**
     * @param Task $task
     * @return array
     *
     * Функция дополняет информацию об откликах необходимыми данными.
     */
    private static function addDataToTaskResponses(Task $task): array
    {
        $responses = $task['responses'];

        return self::addDataForEachResponse($responses, $task);
    }

    /**
     * @param array $responses
     * @param Task $task
     * @return array
     */
    private static function addDataForEachResponse(array $responses, Task $task): array
    {
        foreach ($responses as &$response) {
            $response = self::addDataRelatedToResponse($response, $task['budget']);
        }

        return $responses;
    }

    /**
     * @param Response $response
     * @param $budget
     * @return Response
     *
     * Функция дополняет массив с данными отклика необходимой информацией
     */
    private static function addDataRelatedToResponse(Response $response, $budget): Response
    {

        $response['userEmployee'] = self::findUser($response['user_employee_id']);

        $response['userEmployee']['vote'] = self::countAverageUsersRate($response['user_employee_id']);

        $response['userEmployee']['photo'] = self::findUsersPhoto($response['user_employee_id']);

        $response['userEmployee']['password_hash'] = '';

        $response['your_price'] = $response['your_price'] ?? $budget;

        $response['created_at'] = TimeOperations::timePassed($response['created_at']);

        return $response;
    }
}
