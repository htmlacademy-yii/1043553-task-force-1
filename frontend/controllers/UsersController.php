<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\SecuredController;
use frontend\models\forms\UsersFilterForm;

class UsersController extends SecuredController
{
    public function actionIndex()
    {
        $model = new UsersFilterForm();
        $data = \Yii::$app->userViewComponent->getDataForUsersPage($model);

        return $this->render('index', ["data" => $data, 'model' => $model ]);
    }

    public function actionShow(int $id)
    {
        $data = \Yii::$app->userViewComponent->getDataForUserProfilePage($id);

        return $this->render('show', $data);
    }
}
