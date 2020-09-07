<?php

namespace frontend\components\user;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\components\UserReviewComponent;
use frontend\models\User;
use frontend\models\UserReview;
use yii\base\Component;

class SelectedUserComponent extends Component
{
    use QueriesTrait;

    private $userReviewComponent;

    public function addRelatedDataForEachUser(array $usersData): array
    {
        $newUsersData = [];
        foreach ($usersData as $key => $user) {
            $newUsersData[$key] = $this->addDataRelatedToUser($user, $user["id"]);
        }

        return $newUsersData;
    }

    public function addDataRelatedToUser(User $user, int $userId): User
    {
        $user['usersReviews'] = $this->userReviewComponent->findUserReviews($userId);

        $user['categories'] = self::findUserCategories($userId);

        $user['photo'] = self::findUsersPhoto($userId);

        $user['last_active'] = TimeOperations::timePassed($user['last_active']);

        $user["age"] = TimeOperations::calculateAge($user);

        return $user;
    }

    public function __construct($config = [])
    {
        $this->userReviewComponent = new UserReviewComponent();
        parent::__construct($config);
    }
}
