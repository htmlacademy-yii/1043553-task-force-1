<?php

namespace frontend\components\traits;

use frontend\models\pivot\UsersCategories;
use frontend\models\Response;
use frontend\models\Task;
use frontend\models\User;
use frontend\models\UserPhoto;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;

trait QueriesTrait
{
    private static function getTaskTitle(int $id): string
    {
        $taskTitle = Task::find()
            ->select(['title'])->where(['id' => $id])->asArray()->one();

         return $taskTitle['title'];
    }

    public function getTaskWithResponsesCategoriesFiles(int $id): Task
    {
        $task = Task::find()
            ->select([
                '*',
                'tasks.id as id',
                'tasks.user_employee_id as user_employee_id',
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
            ->where(['current_role' => User::ROLE_EMPLOYEE_CODE])
            ->groupBy(['users.id']);
    }

    private function findUserWithPhotosAndCategories(int $id): User
    {
        $user = $this->findUsersQuery()->where(['users.id' => $id]) ->one();
        if (!$user) {
            throw new NotFoundHttpException("Не найден пользователь с ID: " . $id);
        }

        return $user;
    }

    public static function findUsersPhoto(int $userId): string
    {
        $photo = UserPhoto::find()->select(['photo'])->where(['user_id' => $userId])->one();
        return $photo['photo'] ?? User::DEFAULT_USER_PHOTO;
    }

    public static function findUserName(int $userId): string
    {
        $userName = User::find()
            ->select(['name'])->where(['id' => $userId])->asArray()->one();

        return $userName['name'];
    }

    private static function findUserCategories(int $userId): array
    {
        return UsersCategories::find()
            ->select(['categories.name as name'])
            ->joinWith('categories')
            ->where(['user_id' => $userId])
            ->all();
    }

    public function findAllTaskPendingResponses(int $taskId): array
    {
        return Response::find()
            ->where(['=', 'status', Response::STATUS_PENDING_CODE])
            ->andWhere(['task_id' => $taskId])
            ->all();
    }
}
