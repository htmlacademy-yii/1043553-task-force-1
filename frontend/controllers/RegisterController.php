<?php

namespace frontend\controllers;

use frontend\models\City;
use frontend\models\forms\RegisterForm;
use Yii;
use yii\web\Controller;

class RegisterController extends Controller
{
    public function actionIndex()
    {
        $model = new RegisterForm();

        $cities = City::find()->orderBy(['name' => SORT_ASC])->all();

        $items = ['none' => ''];
        foreach ($cities as $city) {
            $items[$city->id] = $city->name;
        }

        if (Yii::$app->request->getIsPost()) {
            $formData = Yii::$app->request->post();
            if ($model->load($formData) && $model->validate()) {
                if ($model->register()) {
                    return $this->redirect('/tasks');
                } else {
                    return $this->redirect('/register');
                }
            }
        }

        return $this->render('index', ['model' => $model, 'items' => $items]);
       // return $this->render('index');
    }
}