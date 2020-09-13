<?php

namespace frontend\models\forms;

use frontend\models\Response;
use Yii;
use yii\base\Model;
use yii\widgets\ActiveForm;

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
            [['price'], 'required'],
            [['price'], 'integer', 'min' => 1],
            [['comment'], 'string']
        ];
    }

    public function save(int $taskId)
    {
        $response = new Response();

        $response->task_id = $taskId;
        $response->user_employee_id = Yii::$app->user->getId();
        $response->your_price = $this->price;
        $response->comment = $this->comment;
        $response->created_at = time();

        return $response->save(false);
    }

    public function getErrorMessage(): array
    {
        $errors = ActiveForm::validate($this);

        return [
            'price' => $errors["taskresponseform-price"][0] ?? null,
        ];
    }
}