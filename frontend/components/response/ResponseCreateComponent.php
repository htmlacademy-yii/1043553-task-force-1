<?php

namespace frontend\components\response;

use frontend\components\helpers\Checker;
use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\models\forms\TaskResponseForm;
use frontend\models\Response;
use frontend\models\Task;
use Yii;

class ResponseCreateComponent
{
    public static function createResponse(int $taskId)
    {
        $responseFormModel = new TaskResponseForm();
        $formData = Yii::$app->request->post() ?? [];
        if (!$responseFormModel->load($formData) or !$responseFormModel->validate()) {
            return false;
        }

        return $responseFormModel->save($taskId);
    }
}
