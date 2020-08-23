<?php

namespace frontend\components\task;

use frontend\models\forms\TasksFilterForm;
use Yii;
use yii\db\ActiveQuery;

class TaskFilter
{
    private TasksFilterForm $model;
    private ActiveQuery $query;

    private function __construct(TasksFilterForm $model, ActiveQuery $query)
    {
        $this->model = $model;
        $this->query = $query;
    }

    /**
     * @param TasksFilterForm $model
     * @param ActiveQuery $query
     * @return ActiveQuery
     *
     * Функция добавляет в SQL запрос новые параметры в зависмости от выбранных фильтров
     */
    public static function applyFilters(TasksFilterForm $model, ActiveQuery $query): ActiveQuery
    {
        $self = new self($model, $query);
        $filters = Yii::$app->request->post() ?? [];

        if ($model->load($filters)) {
            $self->filterThroughAdditionalFields();
            $self->filterThroughChosenCategories();
            $self->filterThroughChosenPeriod();
            $self->filterThroughSearchField();
        }

        return $self->query;
    }

    /**
     * @return ActiveQuery
     */
    private function filterThroughAdditionalFields(): ActiveQuery
    {
        if ($this->model->additional) {
            foreach ($this->model->additional as $key => $field) {
                $this->model->$field = true;
            }
        }

        if ($this->model->responses) {
            $this->query->joinWith('responses');
            $this->query->andWhere([
                'or',
                ['responses.task_id' => null],
                ['tasks.id' => null]
            ]);
        }

        if ($this->model->cities) {
            $this->query->andWhere(['tasks.address' => null]);
        }

        return $this->query;
    }

    /**
     * @return ActiveQuery
     */
    private function filterThroughChosenCategories(): ActiveQuery
    {
        if ($this->model->categories) {
            $categories = ['or'];
            foreach ($this->model->categories as $categoryId) {
                $categories[] = [
                    'tasks.category_id' => intval($categoryId)
                ];
            }
             return $this->query->andWhere($categories);
        }
        return $this->query;
    }

    /**
     * @return ActiveQuery
     */
    private function filterThroughChosenPeriod(): ActiveQuery
    {
        if ($this->model->period == 'day') {
             return $this->query->andWhere(['>', 'tasks.created_at', strtotime("- 1 day")]);
        } elseif ($this->model->period == 'week') {
             return $this->query->andWhere(['>', 'tasks.created_at', strtotime("- 1 week")]);
        } elseif ($this->model->period == 'month') {
             return $this->query->andWhere(['>', 'tasks.created_at', strtotime("- 1 month")]);
        }

        return $this->query;
    }

    /**
     * @return ActiveQuery
     */
    private function filterThroughSearchField(): ActiveQuery
    {
        if ($this->model->search) {
            return $this->query->andWhere(['like', 'tasks.title', $this->model->search]);
        }

        return $this->query;
    }
}
