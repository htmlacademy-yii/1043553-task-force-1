<?php

namespace frontend\components\user;

use frontend\models\forms\UserProfileSettingsForm;
use frontend\models\pivot\UsersCategories;
use frontend\models\User;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

class UserProfileComponent
{
    private User $user;
    private UsersCategories $userCategories;
    private UserProfileSettingsForm $userProfileSettingsFormModel;

    public function __construct(int $userId, UserProfileSettingsForm $userProfileSettingsFormModel)
    {
        $this->user = User::findOne($userId);
        $this->userProfileSettingsFormModel = $userProfileSettingsFormModel;
        $this->userCategories = new UsersCategories();
    }

    public function updateUserProfile()
    {
        $this->updateAccount();
        $this->updateCategories();
        $this->updatePassword();
        $this->updateTasksPhotos();
        $this->updateContacts();
        $this->updateNotifications();
        $this->updateSettings();
        $this->updateAvatar();

        return var_dump($_FILES);

        return $this->user->update(false);
    }

    private function updateAccount()
    {
        $this->setNewFieldValue('name', $this->user, 'name');
        $this->setNewFieldValue('email', $this->user, 'email');
        $this->setNewFieldValue('cityId', $this->user, 'city_id');
        $this->setNewFieldValue('birthday', $this->user, 'birthday');
        $this->setNewFieldValue('description', $this->user, 'description');
    }


    private function updateCategories()
    {
        if (is_array($this->userProfileSettingsFormModel->categories)) {
            UsersCategories::deleteAll(['user_id' => $this->user->id]);

            \Yii::$app->db->createCommand()
                ->batchInsert(
                    'users_categories',
                    ['user_id', 'category_id'],
                    array_map(function ($id) {
                        return [$this->user->id, $id];
                    }, $this->userProfileSettingsFormModel->categories)
                )
                ->execute();
        }
    }

    private function updatePassword()
    {
        if ($this->userProfileSettingsFormModel->password) {
            $this->user->password_hash = \Yii::$app->getSecurity()
                ->generatePasswordHash($this->model->password);
        }
    }

    private function updateTasksPhotos()
    {
        //
    }

    private function updateContacts()
    {
        $this->setNewFieldValue('phone', $this->user, 'phone');
        $this->setNewFieldValue('skype', $this->user, 'skype');
        //$this->setNewFieldValue('otherMessenger', $this->user, 'other_app');
    }

    private function updateNotifications()
    {
        $this->user->msg_notification
            = $this->userProfileSettingsFormModel->notifications['new-message'];
        $this->user->action_notification
            = $this->userProfileSettingsFormModel->notifications['task-actions'];
        $this->user->review_notification
            = $this->userProfileSettingsFormModel->notifications['new-review'];
    }

    private function updateSettings(): void
    {
        $this->user->show_contacts_all
            = $this->userProfileSettingsFormModel->settings['show-only-client'];
        $this->user->hide_profile
            = $this->userProfileSettingsFormModel->settings['hidden-profile'];
    }

    private function updateAvatar()
    {
        $avatar = UploadedFile::getInstance($this->userProfileSettingsFormModel, 'avatar');
        if ($avatar) {
            $this->user->avatar = uniqid() . ".{$avatar->extension}";
            $filePath
                = "avatars/" . $this->user->avatar;


            $avatar->saveAs($filePath);
        }
    }

    private function setNewFieldValue(string $formModelKey, \yii\db\ActiveRecord $entityModel, string $modelKey)
    {
        if (isset($this->userProfileSettingsFormModel->$formModelKey)) {
            if ($this->userProfileSettingsFormModel->$formModelKey != $entityModel->$modelKey) {
                $entityModel->$modelKey = $this->userProfileSettingsFormModel->$formModelKey;
            }
        }
    }
}


