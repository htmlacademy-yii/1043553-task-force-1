<?php


namespace frontend\controllers;


use frontend\models\Tasks;
use TaskForce\Task;
use yii\db\Query;
use yii\web\Controller;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $query = new Query();
        $data = $query->select([
            'title',
            'description',
            'budget',
            'created_at',
            'categories.name as category',
            'categories.image as image',
            'cities.name as city'

        ])
            ->from('tasks')
            ->join('INNER JOIN', 'categories', 'tasks.category_id = categories.id')
            ->join('INNER JOIN', 'cities', 'tasks.city_id = cities.id')
            ->orderBy(['created_at' => SORT_DESC])->all();

        foreach ($data as $task) {
            $date = time() - $task['created_at'];
            $task['created_at'] = $date % 60;
            $task['created_at'] = 10;
        }


        return $this->render('browse', ["data" => $data]);
    }
}