<?php

namespace backend\helpers;

class ApproveStatus
{
    private static $data = [
        0 => 'ไม่ผ่าน',
        1 => 'ผ่าน'
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
