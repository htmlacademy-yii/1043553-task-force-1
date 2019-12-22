<?php

namespace TaskForce;

class Task
{
    public const STATUS_NEW = 'NEW';
    public const STATUS_CANCELLED = 'CANCELLED';
    public const STATUS_PROCESSING = 'PROCESSING';
    public const STATUS_ACCOMPLISHED = 'ACCOMPLISHED';
    public const STATUS_FAILED = 'FAILED';

    private $actionCancel;
    private $actionAccomplish;
    private $actionRespond ;
    private $actionRefuse;

    private $employeeId;
    private $customerId;
    private $deadline;
    private $currentStatus;

    public function __construct($employeeId, $customerId, $deadline)
    {
        $this->employeeId = $employeeId;
        $this->customerId = $customerId;
        $this->deadline = $deadline;
        $this->currentStatus = self::STATUS_NEW;

        $this->actionCancel = new ActionCancel();
        $this->actionAccomplish = new ActionAccomplish();
        $this->actionRespond = new ActionRespond();
        $this->actionRefuse = new ActionRefuse();
    }

    public function getAction($customerId, $employeeId, $userId)
    {
        $actions = [
            self::STATUS_NEW => [$this->actionCancel, $this->actionRespond],
            self::STATUS_PROCESSING => [$this->actionAccomplish, $this->actionRefuse]
        ];

        if ($actions[$this->currentStatus]) {
            foreach ($actions[$this->currentStatus] as $key => $action) {
                if ($action->checkRights($customerId, $employeeId, $userId) === true) {
                    return $action;
                }
            }
        }
        return null;
    }

    public function getStatuses()
    {
        $statuses = [
            self::STATUS_NEW => ["Отменен" => self::STATUS_CANCELLED, "В работе"  => self::STATUS_PROCESSING],
            self::STATUS_PROCESSING => ["Выполнено"  => self::STATUS_ACCOMPLISHED, "Провалено" => self::STATUS_FAILED]
        ];
            return $statuses[$this->currentStatus] ?? null;
    }

    public function predictStatus($action)
    {
        $statuses = [
           "actionCancel" => [self::STATUS_CANCELLED => "Отменен"],
           "actionRespond" => [self::STATUS_PROCESSING => "В работе"],
            "actionAccomplish" => [self::STATUS_ACCOMPLISHED => "Выполнено"],
            "actionRefuse" => [self::STATUS_FAILED => "Провалено"]
        ];

        if ($action instanceof AbstractAction) {
            return $statuses[$action->getActionCode()] ?? null;
        }

        return null;
    }

    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    public function setCurrentStatus($customerId, $employeeId, $userId)
    {
        $action = $this->getAction($customerId, $employeeId, $userId);

        $status = $this->predictStatus($action) ?? [self::STATUS_NEW => "Новый"];

        $this->currentStatus = array_key_first($status);
    }

    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }
}
