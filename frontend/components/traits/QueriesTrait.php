<?php

namespace frontend\components\traits;

use frontend\components\UserComponent;
use frontend\models\pivot\UsersCategories;
use frontend\models\Task;
use frontend\models\User;
use frontend\models\UsersReview;
use yii\web\NotFoundHttpException;

trait QueriesTrait
{
    public static function findUserWithPhotosAndCategories(int $id): User
    {
        $user = User::find()
            ->where(['users.id' => $id])
            ->joinWith('userPhotos')
            ->joinWith('categories')
            ->one();
        if (!$user) {
            throw new NotFoundHttpException("Юзер с ID $id не найден");
        }

        return $user;
    }

    public static function findUserWithPhotos(int $userId): User
    {
        return User::find()
            ->where(['users.id' => $userId])
            ->joinWith('userPhotos')
            ->one();
    }

    public static function findTaskTitleRelatedToReview(int $employee_id, int $customer_id, int $created_at): string
    {
        $task = Task::find()
            ->select('title')
            ->andwhere(['tasks.user_employee_id' => $employee_id])
            ->andwhere(['tasks.user_customer_id' => $customer_id])
            ->andwhere(['<', 'tasks.created_at', $created_at])
            ->orderBy(['tasks.created_at' => SORT_DESC])
            ->one();

        if (is_null($task)) {
            return UserComponent::NO_TASK_FOUND_MESSAGE;
        } else {
            return strval($task['title']);
        }
    }

    public static function findUsersReview(int $userId): array
    {
        return UsersReview::find()
            ->where(['user_employee_id' => $userId])
            ->all();
    }

    public static function findUsersCategories(int $userId): array
    {
        return UsersCategories::find()
            ->select(['categories.name as name'])
            ->joinWith('categories')
            ->where(['user_id' => $userId])
            ->all();
    }

    public static function countAverageUsersRate(int $userId): int
    {
        return UsersReview::find()
                ->select(['vote'])
                ->where(['user_employee_id' => $userId])
                ->average('vote') ?? 0;
    }

    public static function countAccomplishedTasks(int $userId): int
    {
        return Task::find()
                ->where(['user_employee_id' => $userId])
                ->where(['current_status' => Task::STATUS_ACCOMPLISHED_CODE])
                ->count() ?? 0;
    }

    public static function countUsersReviews(int $userId): int
    {
        return UsersReview::find()
                ->where(['user_employee_id' => $userId])
                ->count() ?? 0;
    }

    public static function getSelectedTaskData(int $id): Task
    {
        $task = Task::find()
            ->joinWith('category')
            ->joinWith('tasksFiles')
            ->joinWith('responses')
            ->where(['tasks.id' => $id])
            ->one();

        if (!$task) {
            throw new NotFoundHttpException("Задание с ID $id не найдено");
        }

        return $task;
    }
}
