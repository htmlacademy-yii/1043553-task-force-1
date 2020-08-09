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

    /**
     * @param UsersFilterForm $model
     * @return array
     *
     * Функция возвращает массив пользователей, фильтруя их по выбранным на странице параметрам
     */
    public static function getDataForUsersPage(UsersFilterForm $model): array
    {
        $query = self::findEmploeesQuery();
        $filters = Yii::$app->request->post() ?? [];

        self::applyFilters($model, $filters, $query);

        $data = $query->all();

         return self::addRelatedDataForEachUser($data);
    }

    /**
     * @param int $id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     */
    public static function getDataForUserProfilePage(int $id): array
    {
        $user = self::findUserWithPhotosAndCategories($id);

        $user = self::addDataRelatedToUser($user, $id);

         return ['user' => $user];
    }
}