<?php


namespace TaskForce;


class TaskStatus
{
    const ROLE_CUSTOMER = '0';
    const ROLE_WORKER = '1';

    const STATUS_NEW = '1';
    const STATUS_CANCELLED = '2';
    const STATUS_PROCESSING = '10';
    const STATUS_ACCOMPLISHED = '100';
    const STATUS_FAILED = '0';

    const ACTION_CANCEL = '2';
    const ACTION_ACCOMPLISH = '100';
    const ACTION_RESPOND = '10';
    const ACTION_REFUSE = '0';

    private $workerId;
    private $customerId;
    private $deadline;
    private $currentStatus;

    public function __construct($workerId, $customerId, $deadline)
    {
        $this->workerId = $workerId;
        $this->customerId = $customerId;
        $this->deadline = $deadline;
        $this->currentStatus = self::STATUS_NEW;
    }

    public function getActions()
    {
        if ($this->currentStatus === self::STATUS_NEW) {
            return [self::ACTION_CANCEL => "Отменить", self::ACTION_RESPOND => "Откликнуться"];
        }

        if ($this->currentStatus === self::STATUS_PROCESSING) {
            return [self::ACTION_ACCOMPLISH => "Завершить", self::ACTION_REFUSE => "Отказаться"];
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
        if ($action === self::ACTION_CANCEL) {
            return [self::STATUS_CANCELLED => "Отменен"];
        }

        if ($action === self::ACTION_RESPOND) {
            return [self::STATUS_PROCESSING => "В работе"];
        }

        if ($action === self::ACTION_ACCOMPLISH) {
            return [self::STATUS_ACCOMPLISHED => "Выполнено"];
        }

        if ($action === self::ACTION_REFUSE) {
            return [self::STATUS_FAILED  => "Провалено"];
        }

        return null;
    }

    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }
}
