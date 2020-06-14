<?php

namespace frontend\models;

use TaskForce\Exception\TaskException;
use Yii;
use yii\db\Query;
use frontend\models\Responses;

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
class Tasks extends \yii\db\ActiveRecord
{
    public function getDataForTasksPage($model)
    {
        $query = $this->noFiltersQuery();
        $filters = Yii::$app->request->post() ?? [];
        if (!$model->load($filters)) {
            //throw new Exception\TaskException('cant load filters data');
        }

        $query = $this->filterThroughAdditionalFields($model, $query);

        $query = $this->filterThroughChosenCategories($model, $query);

        $query = $this->filterThroughChosenPeriod($model, $query);

        $query = $this->filterThroughSearchField($model, $query);


        $data = $query->orderBy(['tasks.created_at' => SORT_DESC])->all();

        foreach ($data as &$task) {
            $task['created_at'] = TimeOperations::timePassed($task['created_at']);
        }

        return $data;
    }

    private function noFiltersQuery(): Query
    {
        $query = new Query();
        return $query->select([
            'tasks.id',
            'title',
            'description',
            'budget',
            'tasks.created_at',
            'categories.name as category',
            'categories.image as image',
            'cities.name as city'

        ])
            ->from('tasks')
            ->join('INNER JOIN', 'categories', 'tasks.category_id = categories.id')
            ->join('INNER JOIN', 'cities', 'tasks.city_id = cities.id')
            ->where(['current_status' => Task::STATUS_NEW]);
    }

    private function filterThroughChosenCategories($model, $query)
    {
        if ($model->categories) {
            $categories = ['or'];
            foreach ($model->categories as $categoryId) {
                $categories[] = [
                    'tasks.category_id' => intval($categoryId)
                ];
            }
            return $query->andWhere($categories);
        }
        return $query;
    }

    private function filterThroughAdditionalFields($model, $query)
    {
        if ($model->additional) {
            foreach ($model->additional as $key => $field) {
                $model->$field = 1;
            }
        }

        if ($model->responses) {
            $query->leftJoin('responses', 'responses.task_id = tasks.id');
            $query->andWhere(['or',
                ['responses.task_id' => null],
                ['tasks.id' => null]
            ]);
        }

        if ($model->cities) {
            $query->andWhere(['tasks.address' => null]);
        }

        return $query;
    }

    private function filterThroughChosenPeriod($model, $query)
    {
        if ($model->period == 'day') {
            return $query->andWhere(['>', 'tasks.created_at',  strtotime("- 1 day")]);
        } elseif ($model->period == 'week') {
            return $query->andWhere(['>', 'tasks.created_at', strtotime("- 1 week")]);
        } elseif ($model->period == 'month') {
            return $query->andWhere(['>', 'tasks.created_at', strtotime("- 1 month")]);
        }

        return $query;
    }

    private function filterThroughSearchField($model, $query)
    {
        if ($model->search) {
            return $query->andWhere(['like', 'tasks.title', $model->search]);
        }

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'user_customer_id',
                    'user_employee_id',
                    'created_at',
                    'title',
                    'description',
                    'category_id',
                    'city_id',
                    'budget'
                ],
                'required'
            ],
            [
                [
                    'user_customer_id',
                    'user_employee_id',
                    'created_at',
                    'category_id',
                    'city_id',
                    'budget',
                    'current_status'
                ],
                'integer'
            ],
            [['description'], 'string'],
            [['deadline'], 'safe'],
            [['title', 'lat', 'lon', 'address'], 'string', 'max' => 50],
            [
                ['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Categories::className(),
                'targetAttribute' => ['category_id' => 'id']
            ],
            [
                ['user_customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['user_customer_id' => 'id']
            ],
            [
                ['user_employee_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Users::className(),
                'targetAttribute' => ['user_employee_id' => 'id']
            ],
            [
                ['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Cities::className(),
                'targetAttribute' => ['city_id' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_customer_id' => 'User Customer ID',
            'user_employee_id' => 'User Employee ID',
            'created_at' => 'Created At',
            'title' => 'Title',
            'description' => 'Description',
            'category_id' => 'Category ID',
            'city_id' => 'City ID',
            'lat' => 'Lat',
            'lon' => 'Lon',
            'address' => 'Address',
            'budget' => 'Budget',
            'deadline' => 'Deadline',
            'current_status' => 'Current Status',
        ];
    }

    /**
     * Gets query for [[Correspondences]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCorrespondences()
    {
        return $this->hasMany(Correspondence::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Responses]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponses()
    {
        return $this->hasMany(Responses::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[UserCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCustomer()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_customer_id']);
    }

    /**
     * Gets query for [[UserEmployee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserEmployee()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_employee_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[TasksFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFiles()
    {
        return $this->hasMany(TasksFiles::className(), ['task_id' => 'id']);
    }


}
