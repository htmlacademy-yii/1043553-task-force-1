<?php

namespace frontend\models\forms;

use frontend\models\Task;
use frontend\models\UserReview;
use Yii;
use yii\base\Model;

/**
 * Signup form
 */
class TaskAccomplishForm extends model
{
    public int $status;
    public string $comment;
    public int $rating;

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
            [['comment', 'rating'], 'required'],
            [['comment'], 'string'],
            [['rating'], 'integer', 'min' => 1, 'max' => 5]
        ];
    }

    public function save(Task $task)
    {
        $task->current_status = $this->status;
        $review = new UserReview();
        $review->task_id = $task->id;
        $review->user_employee_id = $task->user_employee_id;
        $review->user_customer_id = $task->user_customer_id;
        $review->vote = $this->rating;
        $review->created_at = time();
        $review->review = $this->comment;

        return $review->save();

        $transaction = Yii::$app->db->beginTransaction();
        if ($task->save() && $feedback->save()) {
            $transaction->commit();
            return true;
        } else {
            $transaction->rollback();
            return false;
        }
    }

    public function getErrorMessage()
    {
        return "";
    }
}
