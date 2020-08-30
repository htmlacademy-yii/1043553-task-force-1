<?php

namespace frontend\components\user;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\components\UserComponent;
use frontend\models\User;
use frontend\models\UserReview;

class SelectedUser
{
    use QueriesTrait;

    /**
     * @param array $usersData
     * @return array
     */
    public static function addRelatedDataForEachUser(array $usersData): array
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
    public static function addDataRelatedToUser(User $user, int $userId): User
    {
        $user['usersReviews'] = self::findUserReviews($userId);

        $user['categories'] = self::findUserCategories($userId);

        $user['photo'] = self::findUsersPhoto($userId);

        $user['last_active'] = TimeOperations::timePassed($user['last_active']);

        $user["usersReviews"] = self::addRelatedDataForEachReview($user["usersReviews"]);

        $user["age"] = TimeOperations::calculateBirthday($user);

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
        $customer = self::findUserWithPhotosAndCategories($review['user_customer_id']);

        $review['customerPhoto'] = self::findUsersPhoto($review['user_customer_id']);

        $review['customerName'] = $customer['name'];

        $review['taskTitle'] = self::getTaskTitle($review['task_id']) ?? UserComponent::NO_TASK_FOUND_MESSAGE;

        return $review;
    }
}
