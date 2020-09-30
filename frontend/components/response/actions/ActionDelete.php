<?php

namespace frontend\components\response\actions;

use frontend\components\response\ResponseStatusComponent;
use frontend\components\traits\QueriesTrait;
use frontend\models\Response;

class ActionDelete extends AbstractAction
{
    use QueriesTrait;

    public const ACTION_CODE = 30;
    public const STATUS_AFTER_ACTION = Response::STATUS_DELETED_CODE;

    public function processAction(): void
    {
        if ($this->userIsAllowedToProcessAction()) {
            $this->response->delete();
        }
    }

    protected function userIsAllowedToProcessAction(): bool
    {
        return Response::authorisedUserIsResponseCreator($this->response) &&
            ResponseStatusComponent::responseIsPending($this->response);
    }
}
