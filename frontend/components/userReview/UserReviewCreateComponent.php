<?php

namespace frontend\components\userReview;

use frontend\models\forms\TaskAccomplishForm;
use frontend\models\Task;
use yii\widgets\ActiveForm;

class UserReviewCreateComponent
{
    private Task $task;
    private int $taskId;
    private int $statusAfterAction;
    private TaskAccomplishForm $taskAccomplishFormModel;

    public function __construct(Task $task)
    {
        $this->taskAccomplishFormModel = new TaskAccomplishForm();
        $this->task = $task;
        $this->taskId = $task->id;
        $formData = \Yii::$app->request->post() ?? [];
        $this->taskAccomplishFormModel->load($formData);
        $this->statusAfterAction = $this->taskAccomplishFormModel->status;
    }

    public function create(): array
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (\Yii::$app->request->isAjax && ActiveForm::validate($this->taskAccomplishFormModel) === []) {
            return [
                'result' => $this->taskAccomplishFormModel->save($this->task),
                'errors' => $this->taskAccomplishFormModel->getErrorMessage()
            ];
        }
        return ['result' => false, 'errors' => $this->taskAccomplishFormModel->getErrorMessage()];
    }

    public function getStatusAfterAction()
    {
        return $this->statusAfterAction;
    }
}
