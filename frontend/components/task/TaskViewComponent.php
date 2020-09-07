<?php

namespace frontend\components\task;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\models\forms\TasksFilterForm;
use yii\base\Component;

class TaskViewComponent extends Component
{
    use QueriesTrait;

    public function getDataForSelectedTaskPage(): array
    {
        $selectedTask = new SelectedTaskComponent();
        $data = [
            'task' => $selectedTask->getTask(),
            'customer' => $selectedTask->getCustomerData(),
            'responses' => $selectedTask->getTaskResponses(),
            'showResponses' => $selectedTask->getResponseVisibility(),
            'actionButton' => $selectedTask->getTaskAction(),
            'userRole' => $selectedTask->getUserRole(),
        ];

        return TimeOperations::addTimeInfo($data);
    }

    public function getDataForTasksPage(): array
    {
        $tasksFilterFormModel = new TasksFilterForm();
        $query = $this->findNewTasksWithCategoryCityQuery();
        $query = TaskFilterComponent::applyFilters($tasksFilterFormModel, $query);
        $data = $query->orderBy(['tasks.created_at' => SORT_DESC])->all();

        return ['data' => TimeOperations::addTimeInfo($data), 'model' => $tasksFilterFormModel];
    }
}
