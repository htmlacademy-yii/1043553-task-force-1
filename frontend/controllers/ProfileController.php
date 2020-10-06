<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\SecuredController;
use frontend\models\Category;
use frontend\models\City;
use frontend\models\forms\UserProfileSettingsForm;
use Yii;

class ProfileController extends SecuredController
{
    public function actionIndex()
    {
        return $this->render(
            'index',
            [
                'model' => new UserProfileSettingsForm(),
                'user' => Yii::$app->user->identity,
                'cities' => City::getCities(),
                'categories' => Category::getCategoriesListArray(),
            ]
        );
    }

    public function actionUpdate()
    {
        var_dump(Yii::$app->request->post());
        die;
    }
}