<?php

namespace frontend\components\response;

use frontend\components\helpers\Checker;
use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\models\Response;
use frontend\models\Task;

class ResponseViewComponent
{
    use QueriesTrait;

    private Task $task;
    private int $taskCreatorId;
    public array $taskResponses;

    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->taskCreatorId = (int)$this->task['user_customer_id'];
        $this->setResponses();
    }

    private function setResponses(): void
    {
        $responses = $this->task['responses'] ?? [];

        foreach ($responses as $key => $response) {
            $this->taskResponses[$key] = $this->addDataRelatedToResponse($response);

            if (Response::authorisedUserIsResponseCreator($this->taskResponses[$key])) {
                $this->leaveOnlyAuthUserResponseInResponsesList($this->taskResponses[$key]);
            }
        }
    }

    private function addDataRelatedToResponse(Response $response): Response
    {
        $response['userEmployee'] = $this->findUserWithPhotosAndCategories($response['user_employee_id']);
        $response['userEmployee']['photo'] = self::findUsersPhoto($response['user_employee_id']);
        $response['your_price'] = $response['your_price'] ?? $this->task['budget'];
        $response['created_at'] = TimeOperations::timePassed($response['created_at']);
        $response['actionButtonsAreVisible']
            = ResponseVisibilityComponent::getResponseActionButtonsVisibility($this->task, $response);
        $response['status'] = $this->setResponseStatusText((int)$response['status']);

        return $response;
    }

    private function setResponseStatusText(int $status)
    {
        switch ($status) {
            case Response::STATUS_APPROVED_CODE:
                return Response::STATUS_APPROVED_NAME;
            case Response::STATUS_REFUSED_CODE:
                return Response::STATUS_REFUSED_NAME;
            case Response::STATUS_PENDING_CODE:
                return Response::STATUS_PENDING_NAME;
        }
        return Response::STATUS_EXCEPTION;
    }

    private function leaveOnlyAuthUserResponseInResponsesList($response): void
    {
        $this->taskResponses = [0 => $response];
    }
}
