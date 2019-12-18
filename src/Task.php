<?php


namespace TaskForce;


class Task
{
    const STATUS_NEW = 'NEW';
    const STATUS_CANCELLED = 'CANCELLED';
    const STATUS_PROCESSING = 'PROCESSING';
    const STATUS_ACCOMPLISHED = 'ACCOMPLISHED';
    const STATUS_FAILED = 'FAILED';

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

    public function getActions($customerId, $employeeId, $userId)
    {
        $actions = [
            self::STATUS_NEW => [$this->actionCancel, $this->actionRespond],
            self::STATUS_PROCESSING => [$this->actionAccomplish, $this->actionRefuse]
        ];

        if ($actions[$this->currentStatus]) {
            foreach ($actions[$this->currentStatus] as $key=>$action) {
                if ($action->checkRights($customerId, $employeeId, $userId) === true){
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
            self::STATUS_PROCESSING=>["Выполнено"  => self::STATUS_ACCOMPLISHED, "Провалено" => self::STATUS_FAILED]
        ];

        if ($statuses[$this->currentStatus]) {
            return $statuses[$this->currentStatus];
        }

        return null;
    }

    public function predictStatus($action)
    {
        $statuses = [
           "actionCancel" => [self::STATUS_CANCELLED => "Отменен"],
           "actionRespond" => [self::STATUS_PROCESSING => "В работе"],
            "actionAccomplish"=> [self::STATUS_ACCOMPLISHED => "Выполнено"],
            "actionRefuse"=> [self::STATUS_FAILED => "Провалено"]
        ];

        if ($action instanceof AbstractAction && $statuses[$action->getActionCode()]) {
            return $statuses[$action->getActionCode()];
        }
        return null;
    }

    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    public function setCurrentStatus($status){

        $statuses = $this->getStatuses();

        if (!$statuses) {
            return null;
        }
        foreach ($statuses as $key => $value) {
            if ($status === $value) {
                $this->currentStatus = $status;
            }
        }
    }
}
