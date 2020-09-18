<?php

namespace frontend\components\response;

use frontend\components\helpers\Checker;
use frontend\components\task\TaskStatusComponent;
use frontend\components\traits\QueriesTrait;
use frontend\models\Response;
use frontend\models\Task;

class ResponseVisibilityComponent
{
    use QueriesTrait;

    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getResponseVisibility(): bool
    {
        if (Task::authorisedUserIsTaskCreator($this->task)) {
            return true;
        }

        $responses = $this->task['responses'] ?? [];

        foreach ($responses as $key => $response) {
            if (Response::authorisedUserIsResponseCreator($response)) {
                return true;
            }
        }
        return false;
    }

    public static function getResponseActionButtonsVisibility(Task $task, Response $response): bool
    {
        if (TaskStatusComponent::taskIsNotNew($task)) {
            return false;
        }

        if (Task::authorisedUserIsTaskCreator($task) && ResponseStatusComponent::responseIsPending($response)) {
            return true;
        }
        return false;
    }
}
