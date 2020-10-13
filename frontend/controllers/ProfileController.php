<?php

namespace frontend\controllers;

use frontend\controllers\parentControllers\SecuredController;
use frontend\models\Category;
use frontend\models\City;
use frontend\models\forms\UserProfileSettingsForm;
use Yii;
use frontend\components\user\AuthUserComponent;

class ProfileController extends SecuredController
{
    public function actionIndex()
    {
        Yii::$app->user->identity->selectedCategories = AuthUserComponent::getAuthUserCategories();
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
        return \Yii::$app->authUserComponent->updateAuthUserProfile();
        //return $this->redirectBack();
    }
}