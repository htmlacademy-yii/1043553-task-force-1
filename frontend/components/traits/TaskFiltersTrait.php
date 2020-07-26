<?php

namespace frontend\components\traits;

use frontend\components\helpers\TimeOperations;
use frontend\models\forms\TasksFilterForm;
use frontend\models\Task;
use yii\db\ActiveQuery;

trait TaskFiltersTrait
{
    private static function noFiltersQuery(): ActiveQuery
    {
        return Task::find()
            ->select([
                'tasks.id',
                'title',
                'description',
                'budget',
                'tasks.created_at',
                'categories.name as category',
                'categories.image as image',
                'cities.name as city'

            ])
            ->joinWith('category')
            ->joinWith('city')
            ->where(['current_status' => Task::STATUS_NEW_CODE]);
    }

    private static function filterThroughChosenCategories(TasksFilterForm $model, ActiveQuery $query): ActiveQuery
    {
        if ($model->categories) {
            $categories = ['or'];
            foreach ($model->categories as $categoryId) {
                $categories[] = [
                    'tasks.category_id' => intval($categoryId)
                ];
            }
            return $query->andWhere($categories);
        }
        return $query;
    }

    private static function filterThroughAdditionalFields(TasksFilterForm $model, ActiveQuery $query): ActiveQuery
    {
        if ($model->additional) {
            foreach ($model->additional as $key => $field) {
                $model->$field = true;
            }
        }

        if ($model->responses) {
            $query->joinWith('responses');
            $query->andWhere([
                'or',
                ['responses.task_id' => null],
                ['tasks.id' => null]
            ]);
        }

        if ($model->cities) {
            $query->andWhere(['tasks.address' => null]);
        }

        return $query;
    }

    private static function filterThroughChosenPeriod(TasksFilterForm $model, ActiveQuery $query): ActiveQuery
    {
        if ($model->period == 'day') {
            return $query->andWhere(['>', 'tasks.created_at', strtotime("- 1 day")]);
        } elseif ($model->period == 'week') {
            return $query->andWhere(['>', 'tasks.created_at', strtotime("- 1 week")]);
        } elseif ($model->period == 'month') {
            return $query->andWhere(['>', 'tasks.created_at', strtotime("- 1 month")]);
        }

        return $query;
    }

    private static function filterThroughSearchField(TasksFilterForm $model, ActiveQuery $query): ActiveQuery
    {
        if ($model->search) {
            return $query->andWhere(['like', 'tasks.title', $model->search]);
        }

        return $query;
    }

    private static function addTimeInfo(array $data): array
    {
        foreach ($data as &$item) {
            if (isset($item['created_at'])) {
                $item['created_at'] = TimeOperations::timePassed($item['created_at']);
            }
        }

        return $data;
    }
}
