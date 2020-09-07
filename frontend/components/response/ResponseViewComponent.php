<?php

namespace frontend\components\response;

use frontend\components\helpers\Checker;
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
    public bool $responseVisibility;
    public array $taskResponses;

    public function __construct(Task $task)
    {
        $this->task = $task;
        $this->taskCreatorId = (int)$this->task['user_customer_id'];
        $this->setResponses();
        $this->setResponsesVisibility();
    }

    private function setResponsesVisibility(): void
    {
        if (Checker::authorisedUserIsTaskCreator($this->task)) {
            $this->responseVisibility = true;
            return;
        }

        foreach ($this->taskResponses ?? [] as $key => $response) {
            if (Checker::authorisedUserIsResponseCreator($response)) {
                $this->leaveOnlyAuthUserResponseInResponsesList($response);

                $this->responseVisibility = true;
                return;
            }
        }
        $this->responseVisibility = false;
    }

    private function setResponseActionButtonsVisibility(Response $response): bool
    {
        if (Checker::authorisedUserIsTaskCreator($this->task) && Checker::responseIsPending($response)) {
            return true;
        }
        return false;
    }

    private function setResponses(): void
    {
        $responses = $this->task['responses'] ?? [];

        foreach ($responses as $key => $response) {
            $this->taskResponses[$key] = $this->addDataRelatedToResponse($response);
        }
    }

    private function addDataRelatedToResponse(Response $response): Response
    {
        $response['userEmployee'] = $this->findUserWithPhotosAndCategories($response['user_employee_id']);
        $response['userEmployee']['photo'] = self::findUsersPhoto($response['user_employee_id']);
        $response['your_price'] = $response['your_price'] ?? $this->task['budget'];
        $response['created_at'] = TimeOperations::timePassed($response['created_at']);
        $response['actionButtonsAreVisible'] = $this->setResponseActionButtonsVisibility($response);
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
        return "";
    }

    private function leaveOnlyAuthUserResponseInResponsesList($response): void
    {
        $authorisedUserResponse[0] = $response;
        $this->taskResponses = $authorisedUserResponse;
    }
}
