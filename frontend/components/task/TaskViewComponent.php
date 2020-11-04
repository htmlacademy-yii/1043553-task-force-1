<?php

namespace frontend\components\task;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use frontend\models\ChatMessage;
use frontend\models\forms\TasksFilterForm;
use yii\base\Component;
use yii\data\Pagination;


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
            'actionButtonIsVisible' => $selectedTask->getActionButtonVisibility(),
            'showChat' => ChatMessage::getChatVisibility($selectedTask->getTask())
        ];

        \Yii::$app->session['lat'] = $data['task']['lat'];
        \Yii::$app->session['lon'] = $data['task']['lon'];
        \Yii::$app->session['taskId'] = $data['task']['id'];

        return TimeOperations::addTimeInfo($data);
    }

    public function getDataForTasksPage(): array
    {
        $tasksFilterFormModel = new TasksFilterForm();
        $query = $this->findNewTasksWithCategoryCityQuery();
        $query = TaskFilterComponent::applyFilters($tasksFilterFormModel, $query);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $data = $query
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['tasks.created_at' => SORT_DESC])->all();

        return ['data' => TimeOperations::addTimeInfo($data), 'model' => $tasksFilterFormModel, 'pages' => $pages];
    }
}
