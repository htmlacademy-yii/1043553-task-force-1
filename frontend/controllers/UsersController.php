<?php


namespace frontend\controllers;


use frontend\models\Users;
use yii\db\Query;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {
        //$data = Users::find()->asArray()->all();

        $query = new Query();
        $data = $query->select([
            'users.name',
            'users.created_at',
            'users.description',
            'users.last_active',
            'user_photos.photo as photo'

        ])
            ->from('users')
            ->join('INNER JOIN', 'user_photos', 'users.id = user_photos.user_id')
            ->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('users', ["data" => $data]);
    }

}