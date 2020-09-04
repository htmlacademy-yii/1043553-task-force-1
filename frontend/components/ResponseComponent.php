<?php

namespace frontend\components;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\models\Response;
use frontend\models\Task;
use Yii;

class ResponseComponent
{
    use QueriesTrait;

    private Task $task;
    private int $taskCreatorId;
    public bool $showResponses;
    public $taskResponses;

    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->taskCreatorId = (int)$this->task['user_customer_id'];
        $this->showResponses = $this->showResponses();
        $this->taskResponses = $this->addDataForEachResponse();
    }

    private function showResponses(): bool
    {
        $this->taskResponses = $this->task['responses'] ?? [];

        if ($this->taskCreatorId !== Yii::$app->user->getId()) {
            foreach ($this->taskResponses as $key => $response) {
                if ($response['id'] == Yii::$app->user->getId()) {
                    $this->taskResponses = $this->taskResponses[$key];
                    return true;
                }
            }
            return false;
        }
        return true;
    }

    private function addDataForEachResponse(): array
    {
        $newResponsesArray = [];

        foreach ($this->taskResponses as $key => $response) {
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
