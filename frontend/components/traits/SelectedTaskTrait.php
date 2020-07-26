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

    private static function getCustomerData($customerId): User
    {
        $customer = User::find()
            ->joinWith('tasks')
            ->joinWith('userPhotos')
            ->where(['users.id' => $customerId])
            ->asArray()
            ->one();

        $customer['photo'] = $customer['userPhotos'][0]['photo'] ?? UserComponent::DEFAULT_USER_PHOTO;

        return $customer;
    }

    private static function getTaskResponses(Task $task): Response
    {
        $responses = $task['responses'];

        return self::addDataForEachResponse($responses, $task);
    }

    private static function addDataForEachResponse(array $responses, Task $task): array
    {
        foreach ($responses as &$response) {
            $response['userEmployee'] = self::findUserWithPhotos($response['user_employee_id']);

            $response['userEmployee']['vote'] = self::countAverageUsersRate($response['user_employee_id']);

            $response['userEmployee']['photo'] = $response['user_employee']['userPhotos'][0]['photo'] ?? 'default.jpg';

            $response['userEmployee']['password_hash'] = '';

            $response['your_price'] = $response['your_price'] ?? $task['budget'];

            $response['created_at'] = TimeOperations::timePassed($response['created_at']);
        }

        return $responses;
    }
}
