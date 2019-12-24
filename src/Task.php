<?php

namespace TaskForce;

use TaskForce\TaskException\TaskException;

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

    public function __construct(int $employeeId, int $customerId, int $deadline)
    {
        if (!is_int($employeeId) or !is_int($customerId)) {
            throw new TaskException("Айди пользователя должно быть целочисленным");
        }

        if (!$this->checkDate($deadline)) {
            throw new TaskException("Введите дату в указанном формате");
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

    public function getAction(int $customerId, int $employeeId, int $userId): object
    {
        if (!is_int($employeeId) or !is_int($customerId) or !is_int($userId)) {
            throw new TaskException("Айди пользователя должно быть целочисленным");
        }

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

    public function getStatuses(): string
    {
        $statuses = [
            self::STATUS_NEW => ["Отменен" => self::STATUS_CANCELLED, "В работе"  => self::STATUS_PROCESSING],
            self::STATUS_PROCESSING => ["Выполнено"  => self::STATUS_ACCOMPLISHED, "Провалено" => self::STATUS_FAILED]
        ];
            return $statuses[$this->currentStatus] ?? null;
    }

    public function predictStatus($action): array
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

        throw new TaskException("Класс должен являться наследником AbstractAction");
    }

    public function getCurrentStatus(): string
    {
        return $this->currentStatus;
    }

    public function setCurrentStatus($customerId, $employeeId, $userId): void
    {
        if (!is_int($employeeId) or !is_int($customerId) or !is_int($userId)) {
            throw new TaskException("Айди пользователя должно быть целочисленным");
        }

        try {
            $action = $this->getAction($customerId, $employeeId, $userId);

            $status = $this->predictStatus($action) ?? [self::STATUS_NEW => "Новый"];

            $this->currentStatus = array_key_first($status);
        } catch (TaskException $e) {
            error_log("Не удалось установить статус. Ошибка: " . $e->getMessage());
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

    private function checkDate($date): bool
    {
        $dateArray = explode('.', $date);
        return checkdate($dateArray[1], $dateArray[0], $dateArray[2]);
    }
}
