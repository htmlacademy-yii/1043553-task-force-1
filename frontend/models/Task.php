<?php

namespace frontend\models;

use TaskForce\Exception\TaskException;

class Task
{
    public const STATUS_NEW = 0;
    public const STATUS_CANCELLED = 2;
    public const STATUS_PROCESSING = 1;
    public const STATUS_ACCOMPLISHED = 3;
    public const STATUS_FAILED = 4;

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

    public function __construct(int $employeeId, int $customerId, $deadline)
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
    }

    public function getAction(string $role): ?AbstractAction
    {
        try {
            Task::checkRole($role);
        } catch (TaskException $e) {
            error_log("Error:" . $e->getMessage());
        }
        $actions = [
            self::STATUS_NEW => [$this->actionCancel, $this->actionRespond],
            self::STATUS_PROCESSING => [$this->actionAccomplish, $this->actionRefuse]
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
            self::STATUS_NEW => ["Отменен" => self::STATUS_CANCELLED, "В работе"  => self::STATUS_PROCESSING],
            self::STATUS_PROCESSING => ["Выполнено"  => self::STATUS_ACCOMPLISHED, "Провалено" => self::STATUS_FAILED]
        ];
            return $statuses[$this->currentStatus] ?? null;
    }

    public function predictStatus(?AbstractAction $action): ?array
    {
        $statuses = [
           "actionCancel" => [self::STATUS_CANCELLED => "Отменен"],
           "actionRespond" => [self::STATUS_PROCESSING => "В работе"],
            "actionAccomplish" => [self::STATUS_ACCOMPLISHED => "Выполнено"],
            "actionRefuse" => [self::STATUS_FAILED => "Провалено"]
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

            $status = $this->predictStatus($action) ?? [self::STATUS_NEW => "Новый"];

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
        if ($role === self::ROLE_EMPLOYEE or $role === self::ROLE_CUSTOMER) {
            return true;
        }

        throw new TaskException("please use Task::ROLE_ constant");
    }
}
