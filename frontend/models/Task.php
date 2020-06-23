<?php

namespace frontend\models;

use frontend\models\forms\TasksFilterForm;
use TaskForce\Exception\TaskException;
use Yii;
use yii\db\Query;
use frontend\components\BaseTask;

class Task extends BaseTask
{
    public const STATUS_NEW = 0;
    public const STATUS_CANCELLED = 2;
    public const STATUS_PROCESSING = 1;
    public const STATUS_ACCOMPLISHED = 3;
    public const STATUS_FAILED = 4;

    public const ROLE_EMPLOYEE = 0;
    public const ROLE_CUSTOMER = 1;

    public static function getDataForTasksPage(TasksFilterForm $model): array
    {
        $query = self::noFiltersQuery();
        $filters = Yii::$app->request->post() ?? [];

        if ($model->load($filters)) {
            $query = self::filterThroughAdditionalFields($model, $query);

            $query = self::filterThroughChosenCategories($model, $query);

            $query = self::filterThroughChosenPeriod($model, $query);

            $query = self::filterThroughSearchField($model, $query);
        }

        $data = $query->orderBy(['tasks.created_at' => SORT_DESC])->all();

        return self::addTimeInfo($data);
    }

    private static function noFiltersQuery(): Query
    {
        $query = new Query();
        return $query->select([
            'tasks.id',
            'title',
            'description',
            'budget',
            'tasks.created_at',
            'categories.name as category',
            'categories.image as image',
            'cities.name as city'

        ])
            ->from('tasks')
            ->join('INNER JOIN', 'categories', 'tasks.category_id = categories.id')
            ->join('INNER JOIN', 'cities', 'tasks.city_id = cities.id')
            ->where(['current_status' => Task::STATUS_NEW]);
    }

    private static function filterThroughChosenCategories(TasksFilterForm $model, Query $query): Query
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

    private static function filterThroughAdditionalFields(TasksFilterForm $model, Query $query): Query
    {
        if ($model->additional) {
            foreach ($model->additional as $key => $field) {
                $model->$field = true;
            }
        }

        if ($model->responses) {
            $query->leftJoin('responses', 'responses.task_id = tasks.id');
            $query->andWhere(['or',
                ['responses.task_id' => null],
                ['tasks.id' => null]
            ]);
        }

        if ($model->cities) {
            $query->andWhere(['tasks.address' => null]);
        }

        return $query;
    }

    private static function filterThroughChosenPeriod(TasksFilterForm $model, Query $query): Query
    {
        if ($model->period == 'day') {
            return $query->andWhere(['>', 'tasks.created_at',  strtotime("- 1 day")]);
        } elseif ($model->period == 'week') {
            return $query->andWhere(['>', 'tasks.created_at', strtotime("- 1 week")]);
        } elseif ($model->period == 'month') {
            return $query->andWhere(['>', 'tasks.created_at', strtotime("- 1 month")]);
        }

        return $query;
    }

    private static function filterThroughSearchField(TasksFilterForm $model, Query $query): Query
    {
        if ($model->search) {
            return $query->andWhere(['like', 'tasks.title', $model->search]);
        }

        return $query;
    }

    private static function addTimeInfo(array $data): array
    {
        foreach ($data as &$task) {
            $task['created_at'] = TimeOperations::timePassed($task['created_at']);
        }

        return $data;
    }
}
