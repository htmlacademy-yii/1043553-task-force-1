<?php

namespace frontend\components\helpers;

use frontend\models\User;

class TimeOperations
{
    private const SECONDS_IN_MINUTE = 60;
    private const SECONDS_IN_HOUR = 3600;
    private const SECONDS_IN_DAY = 172800;
    private const SECONDS_IN_TWO_DAYS = 86400;

    /**
     * @param $date
     * @return string
     *
     * Фнкция возвращает информацию о количестве прошедшего времени с момента переданного таймстемпа
     */
    public static function timePassed(int $date): string
    {
        $day = date("m.d.y", $date);
        $time = date("H:i:s", $date);

        $timeleft = time() - $date;

        switch ($timeleft) {
            case $timeleft < self::SECONDS_IN_MINUTE:
                return "только что";
                break;
            case $timeleft < self::SECONDS_IN_HOUR:
                $minutes = $timeleft / self::SECONDS_IN_MINUTE;
                return floor($minutes) . self::getNounPluralForm(floor($minutes), ' минута', ' минуты',
                        ' минут') . " назад";
                break;
            case $timeleft === self::SECONDS_IN_HOUR:
                return "час назад";
                break;
            case $timeleft < self::SECONDS_IN_DAY:
                $hours = $timeleft / self::SECONDS_IN_HOUR;
                return floor($hours) . self::getNounPluralForm(floor($hours), ' час', ' часа', ' часов') . " назад";
                break;
            case $timeleft < self::SECONDS_IN_TWO_DAYS:
                return "Вчера в " . $time;
                break;
            case $timeleft > self::SECONDS_IN_TWO_DAYS:
                $fullDate = $day;
                $fullTime = $time;
                return $fullDate . " в " . $fullTime;
                break;
        }
        return "";
    }

    private static function getNounPluralForm(int $number, string $one, string $two, string $many): string
    {
        $number = (int)$number;
        $mod10 = $number % 10;
        $mod100 = $number % 100;

        switch (true) {
            case ($mod100 >= 11 && $mod100 <= 20):
                return $many;

            case ($mod10 > 5):
                return $many;

            case ($mod10 === 1):
                return $one;

            case ($mod10 >= 2 && $mod10 <= 4):
                return $two;

            default:
                return $many;
        }
    }

    /**
     * @param array $data
     * @return array
     *
     * Функция заменяет таймстемп на информацию о количестве прошедшего времени начиная с этого тайстемпа,
     * в переданном ей массиве.
     * Наример: 5 минут назад, вчера в 10:15 и тп
     */
    public static function addTimeInfo(array $data): array
    {
        foreach ($data as &$item) {
            if (isset($item['created_at'])) {
                $item['created_at'] = TimeOperations::timePassed($item['created_at']);
            }
        }

        return $data;
    }

    public static function calculateBirthday(User $user)
    {
        return date_diff(date_create(), date_create($user['birthday']))->format("%y лет");
    }
}
