<?php

namespace frontend\components;

use frontend\components\traits\QueriesTrait;
use frontend\components\user\UserFilter;
use frontend\components\user\SelectedUser;
use frontend\models\forms\UsersFilterForm;

class UserComponent
{
    use QueriesTrait;

    public const DEFAULT_USER_PHOTO = 'default.jpg';
    public const NO_TASK_FOUND_MESSAGE = 'Отзыв добавлен без привязки к заданию';

    /**
     * @param int $id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public static function getDataForUserProfilePage(int $id): array
    {
        $user = self::findUserWithPhotosAndCategories($id);
        $user = SelectedUser::addDataRelatedToUser($user, $id);

        return ['user' => $user];
    }

    /**
     * @param UsersFilterForm $model
     * @return array
     *
     * Функция возвращает массив пользователей, фильтруя их по выбранным на странице параметрам
     */
    public static function getDataForUsersPage(UsersFilterForm $model): array
    {
        $query = self::findUsersQuery();
        $query = UserFilter::applyFilters($model, $query);
        $data = $query->all();

        return SelectedUser::addRelatedDataForEachUser($data);
    }


}
