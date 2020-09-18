<?php

namespace frontend\components\task\actions;

use frontend\components\task\TaskStatusComponent;
use frontend\components\userReview\UserReviewCreateComponent;
use frontend\models\Task;
use frontend\models\User;

class ActionAccomplish extends AbstractAction
{
    public const ACTION_CODE = 20;
    public const ACTION_NAME = "Завершить";
    public const REQUIRED_ROLE = User::ROLE_CUSTOMER_CODE;
    public const TASK_STATUS_AFTER_ACTION = Task::STATUS_ACCOMPLISHED_CODE;
    public const TASK_STATUS_BEFORE_ACTION = Task::STATUS_PROCESSING_CODE;

    private array $reviewErrors;

    public function processAction(): array
    {
        if ($this->userIsAllowedToProcessAction()) {
            return [
                'result' => $this->updateTaskStatusAndAddResponse(),
                'errors' => $this->reviewErrors ?? [],
            ];
        }

        return [
            'result' => false,
            'errors' => self::NO_RIGHTS_EXCEPTION,
        ];
    }

    private function updateTaskStatusAndAddResponse(): bool
    {
        $createReview = new UserReviewCreateComponent($this->task);
        $reviewCreation = $createReview->create();
        if (!$reviewCreation['result']) {
            $this->reviewErrors = $reviewCreation['errors'];
            return false;
        }
        $this->statusAfterAction = $createReview->getStatusAfterAction();
        return TaskStatusComponent::updateTaskStatus($this->task, $this->statusAfterAction);
    }
}
