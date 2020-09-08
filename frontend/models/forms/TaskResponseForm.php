<?php

namespace frontend\models\forms;

use frontend\models\Response;
use Yii;
use yii\base\Model;

class TaskResponseForm extends Model
{
    public $price;
    public $comment;

    public function attributeLabels()
    {
        return [
            'price' => 'Ваша цена',
            'comment' => 'Комментарий'
        ];
    }

    public function rules()
    {
        return [
            [['price', 'comment'], 'safe'],
            [['price', 'comment'], 'required'],
            [['price'], 'integer', 'min' => 1],
            [['comment'], 'string']
        ];
    }

    public function save($taskId)
    {
        $reply = new Response();

        $reply->task_id = $taskId;
        $reply->contractor_id = Yii::$app->user->getId();
        $reply->price = $this->price;
        $reply->comment = $this->comment;

        return $reply->save();
    }
}
