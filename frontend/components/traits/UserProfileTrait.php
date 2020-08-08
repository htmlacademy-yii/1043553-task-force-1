<?php

namespace frontend\components\traits;

use frontend\components\helpers\TimeOperations;
use frontend\components\UserComponent;
use frontend\models\Task;
use frontend\models\User;
use frontend\models\UserReview;

trait UserProfileTrait
{
    use QueriesTrait;

    /**
     * @param array $usersData
     * @return array
     */
    private static function addRelatedDataForEachUser(array $usersData): array
    {
        foreach ($usersData as &$user) {
            $user = self::addDataRelatedToUser($user, $user["id"]);
        }

        return $usersData;
    }

    /**
     * @param User $user
     * @param int $userId
     * @return User
     *
     * Функция дополняет массив с данными пользователя необходимой информацией
     */
    private static function addDataRelatedToUser(User $user, int $userId): User
    {
        $user['vote'] = self::countAverageUsersRate($userId);

        $user['tasksCount'] = self::countAccomplishedTasks($userId);

        $user['reviewsCount'] = self::countUsersReviews($userId);

        $user['usersReviews'] = self::findUsersReview($userId);

        $user['categories'] = self::findUsersWithCategories($userId);

        $user['photo'] = self::findUsersPhoto($userId);

        $user['last_active'] = TimeOperations::timePassed($user['last_active']);

        $user["usersReviews"] = self::addRelatedDataForEachReview($user["usersReviews"]);

        return $user;
    }

    /**
     * @param array $reviews
     * @return array
     *
     */
    private static function addRelatedDataForEachReview(array $reviews): array
    {
        foreach ($reviews as &$review) {
            $review = self::addDataRelatedToReview($review);
        }
        return $reviews;
    }

    /**
     * @param UserReview $review
     * @return UserReview
     *
     * Функция дополняет массив с данными об отзыве необходимой информацией
     */
    private static function addDataRelatedToReview(UserReview $review): UserReview
    {
        $customer = self::findUser($review['user_customer_id']);

        $review['customerPhoto'] = self::findUsersPhoto($review['user_customer_id']);

        $review['customerName'] = $customer['name'];

        $review['taskTitle'] = self::getTaskTitle($review['task_id']) ?? UserComponent::NO_TASK_FOUND_MESSAGE;

        return $review;
    }
}
