<?php


namespace frontend\controllers;

use frontend\models\Users;
use frontend\models\forms\UsersFilterForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $model = new UsersFilterForm();
        $data = (new Users())->getDataForUsersPage($model);
        return $this->render('index', ["data" => $data, 'model' => $model ]);
    }

    public function actionShow(int $id)
    {
        try {
            $data = Users::getDataForSelectedUserPage($id);
            return $this->render('show', $data);
        } catch (NotFoundHttpException $e) {
            return $this->render('/errors/404.php');
        }
    }
}