<?php

namespace frontend\components\user;

use frontend\components\task\TasksHistoryComponent;
use frontend\components\traits\QueriesTrait;
use frontend\models\forms\UserProfileSettingsForm;
use frontend\models\Task;
use frontend\models\User;

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
        $status = $this->getTaskStatusParameterValue();
        $this->getAuthUserCategories();
        $this->tasksHistory = new TasksHistoryComponent($status, $this->userId);
        $this->model = new UserProfileSettingsForm();
        $post = \Yii::$app->request->post() ?? [];
        $this->model->load($post);
    }

    public function getAuthUserTasksHistory(): array
    {
        return $this->tasksHistory->getTasksHistory();
    }

    public static function getAuthUserCategories()
    {
        $categories = self::findUserCategories(\Yii::$app->user->getId());

        foreach ($categories as $category) {
            $categoriesClone[] = $category->category_id;
        }

        return $categoriesClone;
    }

    private function getTaskStatusParameterValue(): string
    {
        return \Yii::$app->request->get()['status'] ?? Task::STATUS_PROCESSING;
    }

    public function updateAuthUserProfile()
    {
        $userProfile = new UserProfileComponent($this->userId, $this->model);
        return $userProfile->updateUserProfile();
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
