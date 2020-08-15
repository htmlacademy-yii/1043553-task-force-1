<?php

namespace frontend\components\traits;

use frontend\components\UserComponent;
use frontend\models\pivot\UsersCategories;
use frontend\models\Task;
use frontend\models\User;
use frontend\models\UserPhoto;
use frontend\models\UserReview;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

trait QueriesTrait
{
    /**
     * @param int $id
     * @return User
     * @throws NotFoundHttpException
     */
    private static function findUserWithPhotosAndCategories(int $id): User
    {
        $user = User::find()
            ->where(['users.id' => $id])
            ->joinWith('userPhotos')
            ->joinWith('categories')
            ->one();
        if (!$user) {
            throw new NotFoundHttpException("Не найден пользователь с ID: " . $id);
        }

         return $user;
    }

    /**
     * @param int $userId
     * @return User
     */
    private static function findUser(int $userId): User
    {
        return User::find()
            ->where(['users.id' => $userId])
            ->one();
    }

    /**
     * @param int $userId
     * @return array
     */
    private static function findUsersReview(int $userId): array
    {
        return UserReview::find()
            ->where(['user_employee_id' => $userId])
            ->all();
    }

    /**
     * @param int $userId
     * @return string
     */
    private static function findUsersPhoto(int $userId): string
    {
        $photo = UserPhoto::find()->select(['photo'])->where(['user_id' => $userId])->one();
         return $photo['photo'] ?? UserComponent::DEFAULT_USER_PHOTO;
    }

    /**
     * @param int $userId
     * @return array
     */
    private static function findUsersWithCategories(int $userId): array
    {
        return UsersCategories::find()
            ->select(['categories.name as name'])
            ->joinWith('categories')
            ->where(['user_id' => $userId])
            ->all();
    }

    /**
     * @param int $userId
     * @return int
     */
    private static function countAverageUsersRate(int $userId): int
    {
        return UserReview::find()
                ->select(['vote'])
                ->where(['user_employee_id' => $userId])
                ->average('vote') ?? 0;
    }

    /**
     * @param int $userId
     * @return int
     */
    private static function countAccomplishedTasks(int $userId): int
    {
        return Task::find()
                ->where(['user_employee_id' => $userId])
                ->where(['current_status' => Task::STATUS_ACCOMPLISHED_CODE])
                ->count() ?? 0;
    }

    /**
     * @param int $userId
     * @return int
     */
    private static function countUsersReviews(int $userId): int
    {
        return UserReview::find()
                ->where(['user_employee_id' => $userId])
                ->count() ?? 0;
    }

    /**
     * @param int $id
     * @return Task
     * @throws NotFoundHttpException
     *
     */
    public static function getTaskWithResponsesCategoriesFiles(int $id): Task
    {
        $task = Task::find()
            ->select(['*',
                'tasks.id as id',
                'categories.name as category',
                'categories.image as image',
            ])
            ->joinWith('responses')
            ->joinWith('category')
            ->joinWith('tasksFiles')
            ->where(['tasks.id' => $id])
            ->one();

        if (!$task) {
            throw new NotFoundHttpException("Не найдено задание с ID: " . $id);
        }

          return $task;
    }

    /**
     * @param int $id
     * @return string
     */
    private static function getTaskTitle(int $id): string
    {
        $taskTitle = Task::find()->select(['title'])->where(['id' => $id])->asArray()->one();
         return $taskTitle['title'];
    }

    /**
     * @return ActiveQuery
     */
    public static function findNewTasksWithCategoryCityQuery(): ActiveQuery
    {
        return Task::find()
            ->select([
                'tasks.id',
                'title',
                'description',
                'budget',
                'tasks.created_at',
                'categories.name as category',
                'categories.image as image',
                'cities.name as city'

            ])
            ->joinWith('category')
            ->joinWith('city')
            ->where(['current_status' => Task::STATUS_NEW_CODE]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    private static function findEmploeesQuery(): ActiveQuery
    {
        return User::find()
            ->select([
                'users.id',
                'users.name',
                'users.last_active',
                'users.description',
                'current_role',
                'AVG(users_review.vote) as vote',
                'COUNT(tasks.id) as tasksCount',
                'COUNT(users_review.id) as reviewsCount'
            ])
            ->distinct()
            ->joinWith('usersReviews')
            ->joinWith('tasks')
            ->where(['current_role' => Task::ROLE_EMPLOYEE])
            ->groupBy(['users.id']);
    }
}
