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

        $customer = self::getCustomerData($task['user_customer_id']);

        $responses = self::addDataToTaskResponses($task);

        $data = ['task' => $task, 'customer' => $customer, 'responses' => $responses];

         return $data = self::addTimeInfo($data);
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

        $filters = Yii::$app->request->post() ?? [];

        $query = self::applyFilters($model, $filters, $query);

        $data = $query->orderBy(['tasks.created_at' => SORT_DESC])->all();

         return self::addTimeInfo($data);
    }
}
