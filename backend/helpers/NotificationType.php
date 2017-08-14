<?php

namespace backend\helpers;

class NotificationType
{
    const SEND_TO_APPROVE = 0;
    const SEND_BACK_APPROVE = 1;
    private static $data = [
        0 => 'Office',
        1 => 'Security'
    ];

    public static function asArray()
    {
        return self::$data;
    }

    public static function getTypeById($idx)
    {
        if (isset(self::$data[$idx])) {
            return self::$data[$idx];
        }

        return 'Unknown Type';
    }
}
