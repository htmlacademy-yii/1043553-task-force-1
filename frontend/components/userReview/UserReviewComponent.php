<?php

namespace frontend\components\userReview;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\models\Response;
use frontend\models\UserReview;
use yii\base\Component;

class UserReviewComponent extends Component
{
    use QueriesTrait;

    public function findUserReviews(int $userId): array
    {
        $reviews = UserReview::find()->where(['user_employee_id' => $userId])->all();

        return $this->addRelatedDataForEachReview($reviews);
    }

    private function addRelatedDataForEachReview(array $reviews): array
    {
        $newReviewsArray = [];
        foreach ($reviews as $key => $review) {
            $newReviewsArray[$key] = $this->addDataRelatedToReview($review);
        }

        return $newReviewsArray;
    }

    private function addDataRelatedToReview(UserReview $review): UserReview
    {
        $customer = $this->findUserWithPhotosAndCategories($review['user_customer_id']);
        $review['customerPhoto'] = self::findUsersPhoto($review['user_customer_id']);
        $review['customerName'] = $customer['name'];
        $review['taskTitle'] = self::getTaskTitle($review['task_id']) ?? UserReview::NO_TASK_FOUND_MESSAGE;

        return $review;
    }
}
