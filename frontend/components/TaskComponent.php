<?php

namespace frontend\components;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\components\task\SelectedTask;
use frontend\components\task\TaskFilter;
use frontend\models\Category;
use frontend\models\forms\TaskCreateForm;
use frontend\models\forms\TasksFilterForm;
use Yii;

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
     * @return array
     *
     * Функция возвращает массив заказов в статусе новый, фильтруя по выбранным на странице параметрам
     */
    public static function getDataForTasksPage(): array
    {
        $model = new TasksFilterForm();
        $query = self::findNewTasksWithCategoryCityQuery();
        $query = TaskFilter::applyFilters($model, $query);
        $data = $query->orderBy(['tasks.created_at' => SORT_DESC])->all();

        return ['data' => TimeOperations::addTimeInfo($data), 'model' => $model];
    }

    public static function getDataForCreatePage(TaskCreateForm $model): array
    {
        return [
            'model' => $model,
            'categoriesList' => Category::getCategoriesListArray(),
            'errors' => $model->getErrors() ?? []
        ];
    }

    public static function createTask(TaskCreateForm $model): bool
    {
        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();

            if ($model->load($formData) && $model->validate()) {
                return $model->save();
            }
        }
        return false;
    }
}
