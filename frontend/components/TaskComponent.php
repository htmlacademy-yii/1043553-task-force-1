<?php

namespace frontend\components;

use frontend\components\traits\SelectedTaskTrait;
use frontend\components\traits\TaskFiltersTrait;
use frontend\models\forms\TasksFilterForm;
use Yii;

class TaskComponent
{
    use TaskFiltersTrait;
    use SelectedTaskTrait;

    public static function getDataForSelectedTaskPage(int $id): array
    {
        $task = self::getSelectedTaskData($id);

        $customer = self::getCustomerData($task['user_customer_id']);

        $responses = self::getTaskResponses($task);

        $data = ['task' => $task, 'customer' => $customer, 'responses' => $responses];

        return $data = self::addTimeInfo($data);
    }

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
}
