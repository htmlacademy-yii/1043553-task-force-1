<?php

namespace frontend\components\user;

use frontend\components\task\TasksHistoryComponent;
use frontend\components\traits\QueriesTrait;
use frontend\models\forms\UserProfileSettingsForm;
use frontend\models\Task;
use frontend\models\User;
use frontend\models\UserPhoto;

class AuthUserComponent
{
    use QueriesTrait;

    private array $tasks;
    private UserProfileSettingsForm $model;
    private TasksHistoryComponent $tasksHistory;
    private int $userId;
    private array $categories;

    public function __construct()
    {
        $this->userId = \Yii::$app->user->getId();

        $this->model = new UserProfileSettingsForm();
    }

    public function getAuthUserTasksHistory(): array
    {
        $status = $this->getTaskStatusParameterValue();
        $this->tasksHistory = new TasksHistoryComponent($status, $this->userId);
        return $this->tasksHistory->getTasksHistory();
    }

    public static function getAuthUserCategories()
    {
        $categories = self::findUserCategories(\Yii::$app->user->getId());

        $categoriesClone = [];
        foreach ($categories as $category) {
            $categoriesClone[] = $category->category_id;
        }

        return $categoriesClone;
    }

    public static function getAuthUserPortfolio(): array
    {
        return UserPhoto::findAll(['user_id' => \Yii::$app->user->getId()]) ?? [];
    }

    private function getTaskStatusParameterValue(): string
    {
        return \Yii::$app->request->get()['status'] ?? Task::STATUS_PROCESSING;
    }

    public function updateAuthUserPortfolio()
    {
        $userProfile = new UserProfileComponent($this->userId);
        return $userProfile->updateUserPortfolio();
    }

    public static function logout(): void
    {
        $user = User::findOne(\Yii::$app->user->getId());
        date_default_timezone_set('Europe/Kiev');
        $user->last_active = date("Y-m-d H:i:s");
        $user->update(false);
        \Yii::$app->user->logout();
    }
}
