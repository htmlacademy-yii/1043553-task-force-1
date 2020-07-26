<?php

namespace frontend\components\traits;

use frontend\components\helpers\TimeOperations;
use frontend\components\UserComponent;
use frontend\models\User;
use frontend\models\UsersReview;

trait UserProfileTrait
{
    use QueriesTrait;


    private static function addDataRelatedToReview(UsersReview $review): UsersReview
    {
        $customer = self::findUserWithPhotos($review['user_customer_id']);

        $review['customerPhoto'] = $customer["userPhotos"]['photo'] ?? UserComponent::DEFAULT_USER_PHOTO;

        $review['customerName'] = $customer['name'];

        $review['taskTitle'] = self::findTaskTitleRelatedToReview(
            $review['user_employee_id'],
            $review['user_customer_id'],
            $review['created_at']
        );

        return $review;
    }

    private static function addRelatedDataForEachReview(array $reviews): array
    {
        foreach ($reviews as &$review) {
            $review = self::addDataRelatedToReview($review);
        }
        return $reviews;
    }

    private static function addDataRelatedToUser(User $user, int $userId): User
    {
        $user['vote'] = self::countAverageUsersRate($userId);

        $user['tasksCount'] = self::countAccomplishedTasks($userId);

        $user['reviewsCount'] = self::countUsersReviews($userId);

        $user['usersReviews'] = self::findUsersReview($userId);

        $user['categories'] = self::findUsersCategories($userId);

        $user['photo'] = $user['userPhotos'][0]['photo'] ?? UserComponent::DEFAULT_USER_PHOTO;

        $user['last_active'] = TimeOperations::timePassed($user['last_active']);

        $user["usersReviews"] = self::addRelatedDataForEachReview($user["usersReviews"]);

        return $user;
    }

    private static function addRelatedDataForEachUser(array $usersData): array
    {
        foreach ($usersData as &$user) {
            $user = self::addDataRelatedToUser($user, $user["id"]);
        }

        return $usersData;
    }
}
