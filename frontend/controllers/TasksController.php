<?php


namespace frontend\controllers;


use frontend\models\Categories;
use frontend\models\Task;
use frontend\models\forms\TasksFilterForm;
use frontend\models\Users;
use Intervention\Image\Exception\NotFoundException;
use yii\web\Controller;
use TaskForce\Exception\TaskException;
use yii\web\NotFoundHttpException;

class TasksController extends Controller
{
    public function actionIndex()
    {
        $model = new TasksFilterForm();
        $data = Task::getDataForTasksPage($model);

        return $this->render('index', ['data' => $data, 'model' => $model]);
    }

    public function actionShow(int $id)
    {
        try {
            $data = Task::getDataForSelectedTaskPage($id);
            return $this->render('show', $data);
        } catch (NotFoundHttpException $e) {
            return $this->render('/errors/404.php');
        }
    }
}