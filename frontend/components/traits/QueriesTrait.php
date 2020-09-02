<?php

namespace frontend\components\traits;

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
     * @return string
     */
    private static function getTaskTitle(int $id): string
    {
        $taskTitle = Task::find()
            ->select(['title'])->where(['id' => $id])->asArray()->one();

         return $taskTitle['title'];
    }

    /**
     * @param int $id
     * @return Task
     * @throws NotFoundHttpException
     *
     */
    public function getTaskWithResponsesCategoriesFiles(int $id): Task
    {
        $task = Task::find()
            ->select([
                '*',
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
     * @return ActiveQuery
     */
    public function findNewTasksWithCategoryCityQuery(): ActiveQuery
    {
        return Task::find()
            ->select([
                'category_id',
                'city_id',

                'tasks.id',
                'title',
                'description',
                'budget',
                'tasks.created_at',
                'categories.name as categoryName',
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
    private function findUsersQuery(): ActiveQuery
    {
        return User::find()
            ->select([
                'users.created_at',
                'users.id',
                'users.name',
                'birthday',
                'users.last_active',
                'users.description',
                'current_role',
                'AVG(users_review.vote) as vote',
                'COUNT(DISTINCT tasks.id) as tasksCount',
                'COUNT(DISTINCT users_review.id) as reviewsCount',
            ])
            ->distinct()
            ->joinWith('usersReviews')
            ->joinWith('tasks')
            ->joinWith('userPhotos')
            ->where(['current_role' => Task::ROLE_EMPLOYEE])
            ->groupBy(['users.id']);
    }

    /**
     * @param int $id
     * @return User
     * @throws NotFoundHttpException
     */
    private function findUserWithPhotosAndCategories(int $id): User
    {
        $user = $this->findUsersQuery()->where(['users.id' => $id]) ->one();
        if (!$user) {
            throw new NotFoundHttpException("Не найден пользователь с ID: " . $id);
        }

        return $user;
    }

    /**
     * @param int $userId
     * @return string
     */
    public static function findUsersPhoto(int $userId): string
    {
        $photo = UserPhoto::find()->select(['photo'])->where(['user_id' => $userId])->one();
        return $photo['photo'] ?? User::DEFAULT_USER_PHOTO;
    }

    /**
     * @param int $userId
     * @return string
     */
    public static function findUserName(int $userId): string
    {
        $userName = User::find()
            ->select(['name'])->where(['id' => $userId])->asArray()->one();

        return $userName['name'];
    }

    /**
     * @param int $userId
     * @return array
     */
    private static function findUserCategories(int $userId): array
    {
        return UsersCategories::find()
            ->select(['categories.name as name'])
            ->joinWith('categories')
            ->where(['user_id' => $userId])
            ->all();
    }
}
