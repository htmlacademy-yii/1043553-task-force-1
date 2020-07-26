<?php

namespace frontend\components;

use frontend\components\traits\UserFiltersTrait;
use frontend\components\traits\UserProfileTrait;
use frontend\models\forms\UsersFilterForm;
use Yii;

class UserComponent
{
    use UserFiltersTrait;
    use UserProfileTrait;

    public const DEFAULT_USER_PHOTO = 'default.jpg';
    public const NO_TASK_FOUND_MESSAGE = 'Отзыв добавлен без привязки к заданию';

    public static function getDataForUsersPage(UsersFilterForm $model): array
    {
        $query = self::noFiltersQuery();
        $filters = Yii::$app->request->post() ?? [];

        if ($model->load($filters)) {
            $query = self::filterThroughAdditionalFields($model, $query);

            $query = self::filterThroughChosenCategories($model, $query);

            $query = self::filterThroughSearchField($model, $query);
        }

        $data = $query->joinWith(['userPhotos'])->all();

        return self::addRelatedDataForEachUser($data);
    }

    public static function getDataForUserProfilePage(int $id): array
    {
        $user = self::findUserWithPhotosAndCategories($id);

        $user = self::addDataRelatedToUser($user, $id);

        return ['user' => $user];
    }
}