<?php

namespace frontend\components\response;

use frontend\models\Response;

class ResponseStatusComponent
{
    public static function updateResponseStatus(Response $response, int $newStatus)
    {
        $response->status = $newStatus;
        $response->save(false);
    }

    public static function responseIsPending(Response $response): bool
    {
        return (int)$response->status === Response::STATUS_PENDING_CODE;
    }

}
