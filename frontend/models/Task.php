<?php

namespace frontend\models;
use TaskForce\Exception\TaskException;

class Task extends \yii\db\ActiveRecord
{
    public const STATUS_NEW_CODE = 0;
    public const STATUS_CANCELLED_CODE = 2;
    public const STATUS_PROCESSING_CODE = 1;
    public const STATUS_ACCOMPLISHED_CODE = 3;
    public const STATUS_FAILED_CODE = 4;

    public const STATUS_NEW_NAME = "Новый";
    public const STATUS_CANCELLED_NAME = "Отменен";
    public const STATUS_PROCESSING_NAME = "В работе";
    public const STATUS_ACCOMPLISHED_NAME = "Выполнено";
    public const STATUS_FAILED_NAME = "Провалено";

    private const GET_POSSIBLE_STATUSES_EXCEPTION = 'Неизвестный индекc в функции getPossibleStatuses';
    private const GET_POSSIBLE_ACTIONS_EXCEPTION = 'Неизвестный индекc в функции getPossibleActions';
    private const PREDICT_STATUS_EXCEPTION = 'Неизвестный индекc в функции predictStatus';
    private const SET_CURRENT_STATUS_EXCEPTION = 'Невозможно поменять статус. Ошибка: ';

    public const ROLE_EMPLOYEE = 0;
    public const ROLE_CUSTOMER = 1;

    private $actionCancel;
    private $actionAccomplish;
    private $actionRespond ;
    private $actionRefuse;

    private $employeeId;
    private $customerId;
    private $deadline;
    private $currentStatus;

    public $image;

    public function getNextAction(int $role): AbstractAction
    {
        try {
            $actions = $this->getPossibleActions();

            foreach ($actions[$this->currentStatus] as $key => $action) {
                if ($action->checkRights($role)) {
                    return $action;
                }
            }
        } catch (TaskException $e) {
            error_log($e->getMessage());
        }
    }

    public function getPossibleStatuses(): array
    {
        $statuses = [
            self::STATUS_NEW_CODE => [
                self::STATUS_CANCELLED_NAME => self::STATUS_CANCELLED_CODE,
                self::STATUS_PROCESSING_NAME => self::STATUS_PROCESSING_CODE
            ],

            self::STATUS_PROCESSING_CODE => [
                self::STATUS_ACCOMPLISHED_NAME => self::STATUS_ACCOMPLISHED_CODE,
                self::STATUS_FAILED_NAME => self::STATUS_FAILED_CODE
            ]
        ];

        if ($statuses[$this->currentStatus]) {
            return $statuses[$this->currentStatus];
        }

        throw new TaskException(self::GET_POSSIBLE_STATUSES_EXCEPTION);
    }

    public function getPossibleActions(): array
    {
        $actions = [
            self::STATUS_NEW_CODE => [$this->actionCancel, $this->actionRespond],
            self::STATUS_PROCESSING_CODE => [$this->actionAccomplish, $this->actionRefuse]
        ];
        if ($actions[$this->currentStatus]) {
            return $actions[$this->currentStatus];
        }

        throw new TaskException(self::GET_POSSIBLE_ACTIONS_EXCEPTION);
    }

    public function predictStatus(AbstractAction $action): array
    {
        $statuses = [
            ActionCancel::ACTION_CODE => [self::STATUS_CANCELLED_CODE => self::STATUS_CANCELLED_NAME],
            ActionRespond::ACTION_CODE => [self::STATUS_PROCESSING_CODE => self::STATUS_PROCESSING_NAME],
            ActionAccomplish::ACTION_CODE => [self::STATUS_ACCOMPLISHED_CODE => self::STATUS_ACCOMPLISHED_NAME],
            ActionRefuse::ACTION_CODE => [self::STATUS_FAILED_CODE => self::STATUS_FAILED_NAME]
        ];

        $actionCode = $action->getActionCode();
        $possibleStatuses = $statuses[$actionCode] ?? false;

        if ($possibleStatuses) {
            return $possibleStatuses;
        }

        throw new TaskException(self::PREDICT_STATUS_EXCEPTION);
    }

    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }

    public function setCurrentStatus(int $role): void
    {
        try {
            $action = $this->getAction($role);
            $status = $this->predictStatus($action);
            $this->currentStatus = array_key_first($status);
        } catch (TaskException $e) {
            error_log(self::SET_CURRENT_STATUS_EXCEPTION . $e->getMessage());
        }
    }

    public function getEmployeeId(): int
    {
        return $this->employeeId;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
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
                'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => 'id']
            ],
            [
                ['user_customer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_customer_id' => 'id']
            ],
            [
                ['user_employee_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['user_employee_id' => 'id']
            ],
            [
                ['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
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
        return $this->hasMany(Response::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[UserCustomer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'user_customer_id']);
    }

    /**
     * Gets query for [[UserEmployee]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserEmployee()
    {
        return $this->hasOne(User::className(), ['id' => 'user_employee_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[TasksFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasksFiles()
    {
        return $this->hasMany(pivot\TasksFiles::className(), ['task_id' => 'id']);
    }

    /*public function __construct(int $employeeId, int $customerId, $deadline)
    {
        $this->employeeId = $employeeId;
        $this->customerId = $customerId;
        $this->deadline = $deadline;
        $this->currentStatus = self::STATUS_NEW_CODE;

        $this->actionCancel = new ActionCancel();
        $this->actionAccomplish = new ActionAccomplish();
        $this->actionRespond = new ActionRespond();
        $this->actionRefuse = new ActionRefuse();
    }*/
}
