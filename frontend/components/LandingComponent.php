<?php

namespace frontend\components;

use frontend\components\helpers\TimeOperations;
use frontend\components\traits\QueriesTrait;
use yii\base\Component;

class LandingComponent extends Component
{
    use QueriesTrait;

    public function getDataForLandingPage(): array
    {
        $tasks = $this->findNewTasksWithCategoryCityQuery()
            ->orderBy(['tasks.created_at' => SORT_DESC])
            ->limit(4)
            ->asArray()
            ->all();

        foreach ($tasks as &$task) {
            $task['created_at'] = TimeOperations::timePassed($task['created_at']);
            $task['description'] = $this->makeStringShorter($task['description'], 70);
        }

        return ['tasks' => $tasks];
    }

    private function makeStringShorter(string $string, $length)
    {
        return substr($string, 0, $length) . '...';
    }
}
