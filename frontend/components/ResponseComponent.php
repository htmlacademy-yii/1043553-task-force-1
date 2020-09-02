<?php

namespace frontend\components;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\models\Response;
use yii\base\Component;

class ResponseComponent extends Component
{
    use QueriesTrait;

    public function addDataForEachResponse(array $responses): array
    {
        $newResponsesArray = [];

        foreach ($responses as $key => $response) {
            $newResponsesArray[$key] = $this->addDataRelatedToResponse($response);
        }

        return $newResponsesArray;
    }

    private function addDataRelatedToResponse(Response $response): Response
    {
        $response['userEmployee'] = $this->findUserWithPhotosAndCategories($response['user_employee_id']);

        $response['userEmployee']['photo'] = self::findUsersPhoto($response['user_employee_id']);

        $response['your_price'] = $response['your_price'] ?? $this->task['budget'];

        $response['created_at'] = TimeOperations::timePassed($response['created_at']);

        return $response;
    }
}
