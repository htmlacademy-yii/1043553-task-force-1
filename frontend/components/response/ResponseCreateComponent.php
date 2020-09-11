<?php

namespace frontend\components\response;

use frontend\components\helpers\Checker;
use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\models\forms\TaskResponseForm;
use frontend\models\forms\UserLoginForm;
use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;
use Yii;
use yii\widgets\ActiveForm;

class ResponseCreateComponent
{
    private int $taskId;
    private array $formData;
    private TaskResponseForm $responseFormModel;

    public function __construct(int $taskId)
    {
        $this->taskId = $taskId;
        $this->formData = \Yii::$app->request->post() ?? [];
        $this->responseFormModel = new TaskResponseForm();
    }

    public function create(): array
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $this->responseFormModel->load($this->formData);

        return $this->responseCreation();
    }

    private function responseCreation(): array
    {
        if (\Yii::$app->request->isAjax && ActiveForm::validate($this->responseFormModel) === []) {
            return [
                'result' => $this->responseFormModel->save($this->taskId),
                'errors' => $this->responseFormModel->getErrorMessage()
            ];
        }
        return ['result' => false, 'errors' => $this->responseFormModel->getErrorMessage()];
    }
}
