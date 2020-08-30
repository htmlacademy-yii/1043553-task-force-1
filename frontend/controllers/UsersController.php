<?php

namespace frontend\controllers;

use frontend\components\UserComponent;
use frontend\models\forms\UsersFilterForm;
use yii\web\Controller;

class UsersController extends SecuredController
{
    public function actionIndex()
    {
        $model = new UsersFilterForm();
        $data = UserComponent::getDataForUsersPage($model);

        return $this->render('index', ["data" => $data, 'model' => $model ]);
    }

    public function actionShow(int $id)
    {
        $data = UserComponent::getDataForUserProfilePage($id);

        return $this->render('show', $data);
    }
}