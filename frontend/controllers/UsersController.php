<?php


namespace frontend\controllers;

use frontend\models\Tasks;
use frontend\models\Users;
use frontend\models\UsersReview;
use yii\db\Query;
use yii\web\Controller;

class UsersController extends Controller
{
    public function actionIndex()
    {

        $query1 = new Query();

        $data = $query1->select([
            'users.id',
            'users.name',
            'users.created_at',
            'users.description',
            'users.last_active',
            'user_photos.photo as photo',
            'users_categories.user_id as categoriesIds'

        ])
            ->from('users')
            ->join('INNER JOIN', 'user_photos', 'users.id = user_photos.user_id')
            ->join('INNER JOIN', 'users_categories', 'users.id = users_categories.user_id')
            ->orderBy(['created_at' => SORT_DESC])->all();

        $usersData = $data;
        foreach ($data as $user) {
            $query2 = new Query();
            $query3 = new Query();

            $usersData[$user["id"]]['vote'] = $query2->select(['vote'])
                    ->from('users_review')
                    ->where(['user_employee_id' => $user["id"]])
                    ->average('vote') ?? 0;

            $usersData[$user["id"]]['tasksCounts'] =
                Tasks::find()
                    ->where(['user_employee_id' => $user["id"]])
                    ->count() ?? 0;

            $usersData[$user["id"]]['usersReviews'] =
                UsersReview::find()
                    ->where(['user_employee_id' => $user["id"]])
                    ->all() ?? 0;

            $usersData[$user["id"]]['reviewsCounts'] = count($usersData[$user["id"]]['usersReviews']) ?? 0;

            $usersData[$user["id"]]['categories'] = $query3->select(['categories.name as category_name'])
                ->from('users_categories')
                ->join('LEFT JOIN', 'categories', 'users_categories.category_id = categories.id')
                ->where(['user_id' => $user["id"]])
                ->all() ?? 0;
        }

        return $this->render('users', ["usersData" => $usersData]);

        /*return $this->render(
            'users',
            [
                "data" => $data,
                "tasksCounts" => $tasksCounts ?? 0,
                "usersReviews" => $usersReviews ?? 0,
                "reviewsCounts" => $reviewsCounts ?? 0,
                "categories" => $categories ?? 0,
                "vote" => $vote
            ]
        );*/
    }

}