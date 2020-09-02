<?php

namespace frontend\components\user;

use frontend\models\forms\UsersFilterForm;
use frontend\models\Task;
use Yii;
use yii\db\ActiveQuery;

class UserFilterComponent
{
    private UsersFilterForm $model;
    private ActiveQuery $query;

    private function __construct(UsersFilterForm $model, ActiveQuery $query)
    {
        $this->model = $model;
        $this->query = $query;
    }

    public static function applyFilters(UsersFilterForm $model, ActiveQuery $query): ActiveQuery
    {
        $self = new self($model, $query);
        $filters = Yii::$app->request->post() ?? [];

        if ($self->model->load($filters)) {
            $self->filterThroughAdditionalFields();

            $self->filterThroughChosenCategories();

            $self->filterThroughSearchField();
        }

        $self->sortUsers();

        return $self->query;
    }

    private function sortUsers(): ActiveQuery
    {
        $sortRule = Yii::$app->request->get()['sortBy'] ?? [];

        switch ($sortRule) {
            case 'rating':
                return $this->query->orderBy(['vote' => SORT_DESC]);

            case 'tasks':
                return $this->query->orderBy(['tasksCount' => SORT_DESC]);

            case 'reviews':
                return $this->query->orderBy(['reviewsCount' => SORT_DESC]);
        }

        return $this->query;
    }

    private function filterThroughAdditionalFields(): ActiveQuery
    {
        if ($this->model->additional) {
            foreach ($this->model->additional as $key => $field) {
                $this->model->$field = true;
            }
        }

        if ($this->model->nowFree) {
            $this->query->joinWith('tasks');
            $this->query->andWhere([
                'or',
                ['tasks.user_employee_id' => null],
                ['users.id' => null],
                ['<>', 'tasks.current_status', Task::STATUS_PROCESSING_CODE]
            ]);
        }

        if ($this->model->nowOnline) {
            $this->query->andWhere(['>', 'last_active', strtotime("- 30 minutes")]);
        }

        if ($this->model->reviews) {
            $this->query->where(['>', 'vote', '0']);
        }

        if ($this->model->remote) {
            if (!$this->model->nowFree) {
                $this->query->joinWith('tasks');
            }
            $this->query->andWhere(['tasks.address' => null]);
        }

        if ($this->model->favorite) {
            $this->query->joinWith('favorites')
                ->andWhere(['favorites.user_id' => Yii::$app->user->getId()]);

        }

        return $this->query;
    }

    private function filterThroughChosenCategories(): ActiveQuery
    {
        if ($this->model->categories) {
            $this->query->joinWith('categories');
            $categories = ['or'];
            foreach ($this->model->categories as $categoryId) {
                $categories[] = [
                    'users_categories.category_id' => intval($categoryId)
                ];
            }
            return $this->query->andWhere($categories);
        }
        return $this->query;
    }

    private function filterThroughSearchField(): ActiveQuery
    {
        if ($this->model->search) {
            return $this->query->andWhere(['like', 'users.name', $this->model->search]);
        }

        return $this->query;
    }
}
