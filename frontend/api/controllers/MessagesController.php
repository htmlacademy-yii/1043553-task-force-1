<?php


namespace frontend\api\controllers;

use frontend\models\ChatMessage;
use Yii;
use yii\rest\ActiveController;

class MessagesController extends ActiveController
{
    public $modelClass = ChatMessage::class;

    public function actions()
    {
        $actions = parent::actions();

        unset($actions['create'], $actions['index'], $actions['view'], $actions['update']);

        return $actions;
    }

    public function init()
    {
        parent::init();
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    }

    public function actionCreate()
    {
        $data = json_decode(Yii::$app->getRequest()->getRawBody());
        $model = new ChatMessage();

        return $model->saveMessage($data->message, $data->taskId);
    }

    public function actionIndex($id)
    {
        return ChatMessage::getChatMessagesForSelectedTask($id);
    }

}