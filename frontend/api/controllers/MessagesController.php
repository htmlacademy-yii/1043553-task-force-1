<?php


namespace frontend\modules\api\controllers;

use Yii;
use yii\rest\ActiveController;
use frontend\models\Chat;
use frontend\models\Task;

class MessagesController extends ActiveController
{
    public $modelClass = Chat::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['index'], $actions['view'], $actions['update']);

        return $actions;
    }

    public function actionCreate($id)
    {
        $data = json_decode(Yii::$app->getRequest()->getRawBody());

        if (strlen($data->message)) {
            $model = new Chat();
            $model->task_id = $id;
            $model->user_id = Yii::$app->user->getId();
            $model->message = $data->message;
            $model->save();
        }

        return;
    }
}