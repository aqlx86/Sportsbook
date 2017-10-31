<?php

namespace SportsBook;

class OddsType
{
    // decimal odds
    const TYPE_DEC = 1;
    // hk odds
    const TYPE_HK = 2;
    // indo odds
    const TYPE_INDO = 3;
    // malay odds
    const TYPE_MY = 4;

    public static function get_cf_odds($odd_type)
    {
        // hard coded cf88 odds type, please refer to cf888.odds_types table

        if ($odd_type == self::TYPE_DEC)
            return 16;
        else if ($odd_type == self::TYPE_HK)
            return 6;
        else if ($odd_type == self::TYPE_INDO)
            return 11;
        else if ($odd_type == self::TYPE_MY)
            return 1;
    }
}