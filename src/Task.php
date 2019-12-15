<?php


namespace TaskForce;


class Task
{
    const ROLE_CUSTOMER = '0';
    const ROLE_EMPLOYEE = '1';

    const STATUS_NEW = 'NEW';
    const STATUS_CANCELLED = 'CANCELLED';
    const STATUS_PROCESSING = 'PROCESSING';
    const STATUS_ACCOMPLISHED = 'ACCOMPLISHED';
    const STATUS_FAILED = 'FAILED';

    /*const ACTION_CANCEL = 'ActionCancel';
    const ACTION_ACCOMPLISH = 'ActionAccomplish';
    const ACTION_RESPOND = 'ActionRespond';
    const ACTION_REFUSE = 'ActionRefuse';*/

    private $action_cancel;
    private $action_accomplish;
    private $action_respond ;
    private $action_refuse;

    protected $employeeId;
    protected $customerId;
    protected $deadline;
    protected $currentStatus;

    public function __construct($employeeId, $customerId, $deadline)
    {
        $this->employeeId = $employeeId;
        $this->customerId = $customerId;
        $this->deadline = $deadline;
        $this->currentStatus = self::STATUS_NEW;

        $this->action_cancel = new ActionCancel();
        $this->action_accomplish = new ActionAccomplish();
        $this->action_respond = new ActionRespond();
        $this->action_refuse = new ActionRefuse();
    }

    public function getActions($customerId, $employeeId, $userId)
    {
        if ($userId === $customerId) {
            if ($this->currentStatus === self::STATUS_NEW) {
                return $this->action_cancel;
            }

            if ($this->currentStatus === self::STATUS_PROCESSING) {
                return $this->action_accomplish;
            }

            return null;
        }

        if ($userId === $employeeId) {
            if ($this->currentStatus === self::STATUS_NEW) {
                return $this->action_respond;
            }

            if ($this->currentStatus === self::STATUS_PROCESSING) {
                return $this->action_refuse;
            }

            return null;
        }

        return null;
    }

    public function getStatuses()
    {
        if ($this->currentStatus === self::STATUS_NEW) {
            return [self::STATUS_CANCELLED => "Отменен", self::STATUS_PROCESSING => "В работе"];
        }

        if ($this->currentStatus === self::STATUS_PROCESSING) {
            return [self::STATUS_ACCOMPLISHED => "Выполнено", self::STATUS_FAILED => "Провалено"];
        }

        return null;
    }

    public function predictStatus($action)
    {
        if ($action == $this->action_cancel) {
            return [self::STATUS_CANCELLED => "Отменен"];
        }

        if ($action == $this->action_respond) {
            return [self::STATUS_PROCESSING => "В работе"];
        }

        if ($action == $this->action_accomplish) {
            return [self::STATUS_ACCOMPLISHED => "Выполнено"];
        }

        if ($action == $this->action_refuse) {
            return [self::STATUS_FAILED => "Провалено"];
        }
        return [$action, $this->action_cancel];
    }

    public function getCurrentStatus()
    {
        return $this->currentStatus;
    }

    public function setCurrentStatus($status){

        switch ($status){
            case ($status === self::STATUS_NEW):
                $this->currentStatus = self::STATUS_NEW;
                break;
            case ($status === self::STATUS_FAILED):
                if($this->currentStatus === self::STATUS_PROCESSING){
                $this->currentStatus = self::STATUS_FAILED;
                } else {
                    return "cant change status";
                }
                break;
            case ($status === self::STATUS_PROCESSING):
                if($this->currentStatus === self::STATUS_NEW){
                $this->currentStatus = self::STATUS_PROCESSING;
                } else {
                    return "cant change status";
                }
                break;
            case ($status === self::STATUS_ACCOMPLISHED):
                if($this->currentStatus === self::STATUS_PROCESSING){
                $this->currentStatus = self::STATUS_ACCOMPLISHED;
                } else {
                    return "cant change status";
                }
                break;
            case ($status === self::STATUS_CANCELLED):
                if ($this->currentStatus === self::STATUS_NEW) {
                $this->currentStatus = self::STATUS_CANCELLED;
                } else {
                    return "cant change status";
                }
                break;
        }
    }
}
