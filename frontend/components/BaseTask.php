<?php
namespace frontend\components;

use frontend\models\Task;
use frontend\models\Categories;
use frontend\models\TasksFiles;
use frontend\models\Responses;

class BaseTask extends \yii\db\ActiveRecord
{
    private $actionCancel;
    private $actionAccomplish;
    private $actionRespond ;
    private $actionRefuse;

    private $employeeId;
    private $customerId;
    private $deadline;
    private $currentStatus;

   /* public function __construct(int $employeeId, int $customerId, $deadline)
    {
        try {
            $this->checkDate($deadline);
        } catch (TaskException $e) {
            error_log("Error:" . $e->getMessage());
        }
        $this->employeeId = $employeeId;
        $this->customerId = $customerId;
        $this->deadline = $deadline;
        $this->currentStatus = self::STATUS_NEW;

        $this->actionCancel = new ActionCancel();
        $this->actionAccomplish = new ActionAccomplish();
        $this->actionRespond = new ActionRespond();
        $this->actionRefuse = new ActionRefuse();
    }*/

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



    public function getAction(string $role): ?AbstractAction
    {
        try {
            Task::checkRole($role);
        } catch (TaskException $e) {
            error_log("Error:" . $e->getMessage());
        }
        $actions = [
            Task::STATUS_NEW => [$this->actionCancel, $this->actionRespond],
            Task::STATUS_PROCESSING => [$this->actionAccomplish, $this->actionRefuse]
        ];

        if ($actions[$this->currentStatus]) {
            foreach ($actions[$this->currentStatus] as $key => $action) {
                if ($action->checkRights($role)) {
                    return $action;
                }
            }
        }
        return null;
    }

    public function getStatuses(): ?string
    {
        $statuses = [
            Task::STATUS_NEW => ["Отменен" => Task::STATUS_CANCELLED, "В работе"  => Task::STATUS_PROCESSING],
            Task::STATUS_PROCESSING => ["Выполнено"  => Task::STATUS_ACCOMPLISHED, "Провалено" => Task::STATUS_FAILED]
        ];
        return $statuses[$this->currentStatus] ?? null;
    }

    public function predictStatus(?AbstractAction $action): ?array
    {
        $statuses = [
            "actionCancel" => [Task::STATUS_CANCELLED => "Отменен"],
            "actionRespond" => [Task::STATUS_PROCESSING => "В работе"],
            "actionAccomplish" => [Task::STATUS_ACCOMPLISHED => "Выполнено"],
            "actionRefuse" => [Task::STATUS_FAILED => "Провалено"]
        ];

        if ($action) {
            return $statuses[$action->getActionCode()] ?? null;
        }

        return null;
    }

    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }

    public function setCurrentStatus(string $role): void
    {
        try {
            Task::checkRole($role);
        } catch (TaskException $e) {
            error_log("Cant change status. Error: " . $e->getMessage());
        }
        $action = $this->getAction($role);

        $status = $this->predictStatus($action) ?? [Task::STATUS_NEW => "Новый"];

        $this->currentStatus = array_key_first($status);
    }

    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    private function checkDate($date): bool
    {
        $dateArray = explode('.', $date);

        if (!$dateArray) {
            throw new TaskException("Please enter date in format dd.mm.yyyy");
        }

        $checkDate = checkdate($dateArray[1], $dateArray[0], $dateArray[2]);

        if (!$checkDate) {
            throw new TaskException("Please enter valid date");
        }

        return $checkDate;
    }

    public static function checkRole($role)
    {
        if ($role === Task::ROLE_EMPLOYEE or $role === Task::ROLE_CUSTOMER) {
            return true;
        }

        throw new TaskException("please use Task::ROLE_ constant");
    }
}