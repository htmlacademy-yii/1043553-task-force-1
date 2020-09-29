<?php

namespace frontend\components\task;

use App\Http\Controllers\Api\TaskController;
use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\models\forms\TasksFilterForm;
use frontend\models\Task;
use frontend\models\User;
use yii\base\Component;

class TaskViewComponent extends Component
{
    use QueriesTrait;

    public static function taskIsNotAccessible(int $taskId = null): bool
    {
        $selectedTaskId = $taskId ?? (int)\Yii::$app->request->get('id');
        $task = Task::findOne($selectedTaskId);
        return !Task::authUserCanAccessTask($task);
    }

    public function getDataForSelectedTaskPage(): array
    {
        $selectedTask = new SelectedTaskComponent();
        $data = [
            'task' => $selectedTask->getTask(),
            'customer' => $selectedTask->getCustomerData(),
            'responses' => $selectedTask->getTaskResponses(),
            'showResponses' => $selectedTask->getResponseVisibility(),
            'actionButton' => $selectedTask->getTaskAction(),
            'actionButtonIsVisible' => $selectedTask->getActionButtonVisibility()
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
