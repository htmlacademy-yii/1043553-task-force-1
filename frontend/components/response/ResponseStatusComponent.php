<?php

namespace frontend\components\response;


use frontend\components\response\actions\ActionApprove;
use frontend\components\response\actions\ActionDeny;
use frontend\components\task\TaskStatusComponent;
use frontend\components\traits\QueriesTrait;
use frontend\models\Response;
use frontend\models\Task;

class ResponseStatusComponent
{
    use QueriesTrait;

    private int $userRoleCode;
    private int $responseId;
    private ActionDeny $actionDeny;
    private ActionApprove $actionApprove;
    private Response $response;

    public function denyResponse(): void
    {
        $this->actionDeny->processAction($this->response, $this->userRoleCode);
    }

    public function approveResponse(): void
    {
        $this->actionApprove->processAction($this->response, $this->userRoleCode);
        $this->denyAllTaskResponsesExceptApproved();
        $task = Task::findOne($this->response->task_id);
        TaskStatusComponent::setStatusProcessing($task, $this->response->user_employee_id);
    }

    private function denyAllTaskResponsesExceptApproved(): void
    {
        $pendingResponses = $this->findAllTaskPendingResponses($this->response->task_id) ?? [];

        foreach ($pendingResponses as $response) {
            $this->response = $response;
            $this->denyResponse();
        }
    }

    public function __construct(int $userRoleCode, $responseId)
    {
        $this->userRoleCode = $userRoleCode;
        $this->responseId = $responseId;
        $this->response = Response::findOne($responseId);

        $this->actionDeny = new ActionDeny();
        $this->actionApprove = new ActionApprove();
    }
}
