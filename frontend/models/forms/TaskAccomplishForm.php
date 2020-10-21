<?php

namespace frontend\models\forms;

use frontend\models\Task;
use frontend\models\UserReview;
use yii\base\Model;
use yii\widgets\ActiveForm;

/**
 * Signup form
 */
class TaskAccomplishForm extends model
{
    public $status;
    public $comment;
    public $rating;

    public function attributeLabels()
    {
        return [
            'comment' => 'Комментарий',
            'rating' => 'Оценка'
        ];
    }

    public function rules()
    {
        return [
            [['status', 'comment', 'rating'], 'safe'],
            [['rating'], 'required'],
            [['comment'], 'string'],
            [['rating'], 'integer', 'min' => 1, 'max' => 5]
        ];
    }

    public function save(Task $task)
    {
        $review = new UserReview();
        $review->task_id = $task->id;
        $review->user_employee_id = $task->user_employee_id;
        $review->user_customer_id = $task->user_customer_id;
        $review->vote = $this->rating;
        //$review->created_at = time();
        $review->review = $this->comment;

        return $review->save(false);
    }

    public function getErrorMessage()
    {
        $errors = ActiveForm::validate($this);

        return [
            'rating' => $errors["taskaccomplishform-rating"][0] ?? null,
        ];
    }
}
