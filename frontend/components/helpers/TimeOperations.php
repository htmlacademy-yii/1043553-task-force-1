<?php

namespace frontend\components\helpers;

use frontend\models\User;

class TimeOperations
{
    private const NO_BIRTHDAY_MESSAGE = 'дата рождения не указана';
    private const SECONDS_IN_MINUTE = 60;
    private const SECONDS_IN_HOUR = 3600;
    private const SECONDS_IN_DAY = 172800;
    private const SECONDS_IN_TWO_DAYS = 86400;

    public static function timePassed(int $date): string
    {
        $day = date("m.d.y", $date);
        $time = date("H:i:s", $date);

        $timeleft = time() - $date;

        switch ($timeleft) {
            case $timeleft < self::SECONDS_IN_MINUTE:
                return "только что";
            case $timeleft < self::SECONDS_IN_HOUR:
                $minutes = $timeleft / self::SECONDS_IN_MINUTE;
                return floor($minutes) . self::getNounPluralForm(floor($minutes), ' минута', ' минуты',
                        ' минут') . " назад";
            case $timeleft === self::SECONDS_IN_HOUR:
                return "час назад";
            case $timeleft < self::SECONDS_IN_DAY:
                $hours = $timeleft / self::SECONDS_IN_HOUR;
                return floor($hours) . self::getNounPluralForm(floor($hours), ' час', ' часа', ' часов') . " назад";
            case $timeleft < self::SECONDS_IN_TWO_DAYS:
                return "Вчера в " . $time;
            case $timeleft > self::SECONDS_IN_TWO_DAYS:
                $fullDate = $day;
                $fullTime = $time;
                return $fullDate . " в " . $fullTime;
        }
        return "";
    }

    private static function getNounPluralForm(int $number, string $one, string $two, string $many): string
    {
        $number = (int)$number;
        $mod10 = $number % 10;

        switch (true) {
            case ($mod10 === 1):
                return $one;

            case ($mod10 >= 2 && $mod10 <= 4):
                return $two;

            default:
                return $many;
        }
    }

    public static function addTimeInfo(array $data): array
    {
        foreach ($data as &$item) {
            if (isset($item['created_at'])) {
                $item['created_at'] = TimeOperations::timePassed($item['created_at']);
            }
        }

        return $data;
    }

    public static function calculateAge(User $user): string
    {
        if ($user['birthday']) {
            return date_diff(date_create(), date_create($user['birthday']))->format("%y лет");
        }

        return self::NO_BIRTHDAY_MESSAGE;
    }
}
