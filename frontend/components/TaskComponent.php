<?php

namespace frontend\components;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\components\task\SelectedTask;
use frontend\components\task\TaskFilter;
use frontend\models\forms\TasksFilterForm;

class TaskComponent
{
    use QueriesTrait;

    /**
     * @param int $id
     * @return array
     * @throws \yii\web\NotFoundHttpException
     *
     * Функция возвращвет массив c данными необходимыми для отображения на странице с выбраным заданием ( /tasks/id )
     */
    public static function getDataForSelectedTaskPage(int $id): array
    {
        $task = self::getTaskWithResponsesCategoriesFiles($id);
        $selectedTask = new SelectedTask($task);
        $customer = $selectedTask->getCustomerData();
        $responses = $selectedTask->addDataToTaskResponses();
        $data = ['task' => $task, 'customer' => $customer, 'responses' => $responses];

        return TimeOperations::addTimeInfo($data);
    }

    /**
     * @param TasksFilterForm $model
     * @return array
     *
     * Функция возвращает массив заказов в статусе новый, фильтруя по выбранным на странице параметрам
     */
    public static function getDataForTasksPage(TasksFilterForm $model): array
    {
        $query = self::findNewTasksWithCategoryCityQuery();
        $query = TaskFilter::applyFilters($model, $query);
        $data = $query->orderBy(['tasks.created_at' => SORT_DESC])->all();

        return TimeOperations::addTimeInfo($data);
    }
}
