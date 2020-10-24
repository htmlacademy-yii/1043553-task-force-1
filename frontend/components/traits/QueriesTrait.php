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

    private function getUserTasksInChosenStatus(string $status, int $userId): array
    {
        $query = Task::find()
            ->select(['*'])
            ->distinct()
            ->andWhere([
                'or',
                ['tasks.user_customer_id' => $userId],
                ['tasks.user_employee_id' => $userId]
            ]);

        switch ($status) {
            case Task::STATUS_NEW:
                $query = $query->andWhere(['current_status' => Task::STATUS_NEW_CODE]);
                break;
            case Task::STATUS_PROCESSING:
                $query = $query->andWhere(['current_status' => Task::STATUS_PROCESSING_CODE]);
                break;
            case Task::STATUS_ACCOMPLISHED:
                $query = $query->andWhere(['current_status' => Task::STATUS_ACCOMPLISHED_CODE]);
                break;
            case Task::STATUS_FAILED:
                $query = $query->andWhere(['current_status' => Task::STATUS_FAILED_CODE]);
                break;
            case Task::STATUS_CANCELLED:
                $query = $query->andWhere(['current_status' => Task::STATUS_CANCELLED_CODE]);
                break;
            default:
                throw new \Exception('заданий в статусе ' . $status . 'нет');
        }

        return $query->all();
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

    public function findAllTaskPendingResponses(int $taskId): array
    {
        return Response::find()
            ->where(['=', 'status', Response::STATUS_PENDING_CODE])
            ->andWhere(['task_id' => $taskId])
            ->all();
    }

    private function findUsersQuery(): ActiveQuery
    {
        return User::find()
            ->select([
                'user_photos.photo',
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
            ->groupBy(['users.id', 'user_photos.id']);
    }

    private function findUserWithPhotosAndCategories(int $id): User
    {
        $user = $this->findUsersQuery()->where(['users.id' => $id])->one();
        if (!$user) {
            throw new NotFoundHttpException("Не найден пользователь с ID: " . $id);
        }

        return $user;
    }

    private function findUserWithAvatarAndVote(int $id): User
    {
        $user = User::find()
            ->select(['*', 'users.id', 'AVG(users_review.vote) as vote'])
            ->joinWith('usersReviews')
            ->where(['users.id' => $id])
            ->groupBy(['users.id', 'users_review.id'])
            ->one();
        $user['avatar'] = $user['avatar'] ?? User::DEFAULT_USER_PHOTO;
        return $user;
    }

    public static function findUsersPhoto(int $userId): string
    {
        $user = User::findOne($userId);
        return $user['avatar'] ?? User::DEFAULT_USER_PHOTO;
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
            ->select(['categories.id as category_id','categories.name as name'])
            ->joinWith('categories')
            ->where(['user_id' => $userId])
            ->all();
    }
}
