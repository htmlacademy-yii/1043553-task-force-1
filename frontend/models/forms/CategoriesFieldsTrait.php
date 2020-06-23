<?php

namespace frontend\models\forms;

use TaskForce\Exception\TaskException;
use Yii;
use yii\db\Query;
use frontend\models\Responses;
use frontend\models\Categories;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property int $user_customer_id
 * @property int $user_employee_id
 * @property int $created_at
 * @property string $title
 * @property string $description
 * @property int $category_id
 * @property int $city_id
 * @property string|null $lat
 * @property string|null $lon
 * @property string|null $address
 * @property int $budget
 * @property string|null $deadline
 * @property int|null $current_status
 *
 * @property Correspondence[] $correspondences
 * @property Responses[] $responses
 * @property Categories $category
 * @property Users $userCustomer
 * @property Users $userEmployee
 * @property Cities $city
 * @property TasksFiles[] $tasksFiles
 */
trait CategoriesFieldsTrait
{
    public function categoriesFields()
    {
        $categories = Categories::find()->all();
        $data = [];

        foreach ($categories as $category) {
            $data[$category['id']] = $category['name'];
        }

        return $data;
    }
}
