<?php

namespace backend\helpers;

class CarState
{
    const CAR_STATE_WAIT_IN = 0;
    const CAR_STATE_IN = 1;
    const CAR_STATE_WAIT_OUT = 2;
    const CAR_STATE_OUT = 3;

    private static $data = [
        0 => 'รอเข้า',
        1 => 'เข้า',
        2 => 'รอออก',
        3 => 'ออก',
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
