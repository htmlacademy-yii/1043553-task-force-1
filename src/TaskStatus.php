<?php


namespace TaskForce;


class TaskStatus
{
    const ROLE_EMPLOYER = 'employer';
    const ROLE_WORKER = 'worker';

    const STATUS_NEW = 'new';
    const STATUS_CANCELLED = 'cancelled';
    const STATUS_PROCESSING = 'processing';
    const STATUS_ACCOMPLISHED = 'accomplished';
    const STATUS_FAILED = 'failed';

    const ACTION_CANCEL = 'cancel';
    const ACTION_ACCOMPLISH = 'accomplish';
    const ACTION_TAKE = 'take';
    const ACTION_REFUSE = 'refuse';

    private $workerId;
    private $employerId;
    private $deadline;
    private $status;

    public function __construct($workerId, $employerId, $deadline)
    {
        $this->workerId = $workerId;
        $this->employerId = $employerId;
        $this->deadline = $deadline;
        $this->status = self::STATUS_NEW;
    }

    public function getActions()
    {
        if ($this->status === self::STATUS_NEW) {
            return [self::ACTION_CANCEL, self::ACTION_TAKE];
        }

        if ($this->status === self::STATUS_PROCESSING) {
            return [self::ACTION_ACCOMPLISH, self::ACTION_REFUSE];
        }

        return null;
    }

    public function getStatuses()
    {
        if ($this->status === self::STATUS_NEW) {
            return [self::STATUS_CANCELLED, self::STATUS_PROCESSING];
        }

        if ($this->status === self::STATUS_PROCESSING) {
            return [self::STATUS_ACCOMPLISHED, self::STATUS_FAILED];
        }

        return null;
    }

    public function predictStatus($action)
    {
        if ($action === self::ACTION_CANCEL) {
            return self::STATUS_CANCELLED;
        }

        if ($action === self::ACTION_TAKE) {
            return self::STATUS_PROCESSING;
        }

        if ($action === self::ACTION_ACCOMPLISH) {
            return self::STATUS_ACCOMPLISHED;
        }

        if ($action === self::ACTION_REFUSE) {
            return self::STATUS_FAILED;
        }

        return null;
    }

    public function getCurrentStatus(): string
    {
        return $this->status;
    }
}
