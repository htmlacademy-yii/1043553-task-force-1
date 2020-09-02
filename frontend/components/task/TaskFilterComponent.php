<?php

namespace frontend\components\task;

use frontend\models\forms\TasksFilterForm;
use Yii;
use yii\db\ActiveQuery;

class TaskFilterComponent
{
    private TasksFilterForm $model;
    private ActiveQuery $query;

    private const DAY_PERIOD_VALUE = 'day';
    private const WEEK_PERIOD_VALUE = 'week';
    private const MONTH_PERIOD_VALUE = 'month';

    private function __construct(TasksFilterForm $model, ActiveQuery $query)
    {
        $this->model = $model;
        $this->query = $query;
    }

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

    private function filterThroughChosenPeriod(): ActiveQuery
    {
        if ($this->model->period === self::DAY_PERIOD_VALUE) {
             return $this->query->andWhere(['>', 'tasks.created_at', strtotime("- 1 day")]);
        } elseif ($this->model->period === self::WEEK_PERIOD_VALUE) {
             return $this->query->andWhere(['>', 'tasks.created_at', strtotime("- 1 week")]);
        } elseif ($this->model->period === self::MONTH_PERIOD_VALUE) {
             return $this->query->andWhere(['>', 'tasks.created_at', strtotime("- 1 month")]);
        }

        return $this->query;
    }

    private function filterThroughSearchField(): ActiveQuery
    {
        if ($this->model->search) {
            return $this->query->andWhere(['like', 'tasks.title', $this->model->search]);
        }

        return $this->query;
    }
}
