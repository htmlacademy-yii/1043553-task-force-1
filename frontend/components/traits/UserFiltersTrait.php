<?php


namespace frontend\components\traits;


use frontend\models\forms\UsersFilterForm;
use frontend\models\Task;
use frontend\models\User;
use yii\db\ActiveQuery;

trait UserFiltersTrait
{
    /**
     * @return \yii\db\ActiveQuery
     */
    private static function noFiltersQuery(): ActiveQuery
    {
        return User::find()
            ->select([
                'users.id',
                'users.name',
                'users.last_active',
                'users.description',
                'users.last_active',
                'current_role',
                'user_photos.photo'
            ])
            ->distinct()
            ->where(['current_role' => Task::ROLE_EMPLOYEE]);
    }

    private static function filterThroughAdditionalFields(UsersFilterForm $model, ActiveQuery $query): ActiveQuery
    {
        if ($model->additional) {
            foreach ($model->additional as $key => $field) {
                $model->$field = true;
            }
        }

        if ($model->nowFree) {
            $query->joinWith('tasks');
            $query->andWhere([
                'or',
                ['tasks.user_employee_id' => null],
                ['users.id' => null],
                ['<>', 'tasks.current_status', Task::STATUS_PROCESSING_CODE]
            ]);
        }

        if ($model->nowOnline) {
            $query->andWhere(['>', 'last_active', strtotime("- 30 minutes")]);
        }

        if ($model->reviews) {
            $query->joinWith('usersReviews');
        }

        if ($model->remote) {
            if (!$model->nowFree) {
                $query->joinWith('tasks');
            }
            $query->andWhere(['tasks.address' => null]);
        }

        /*if ($model->favorite) {

        }*/

        return $query;
    }

    private static function filterThroughChosenCategories(UsersFilterForm $model, ActiveQuery $query): ActiveQuery
    {
        if ($model->categories) {
            $query->joinWith('categories');
            $categories = ['or'];
            foreach ($model->categories as $categoryId) {
                $categories[] = [
                    'users_categories.category_id' => intval($categoryId)
                ];
            }
            return $query->andWhere($categories);
        }
        return $query;
    }

    private static function filterThroughSearchField(UsersFilterForm $model, ActiveQuery $query): ActiveQuery
    {
        if ($model->search) {
            return $query->andWhere(['like', 'users.name', $model->search]);
        }

        return $query;
    }
}