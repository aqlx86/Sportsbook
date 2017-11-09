<?php

namespace SportsBook;

class OddsType
{
    // decimal odds
    const TYPE_DEC = 16;
    // hk odds
    const TYPE_HK = 6;
    // indo odds
    const TYPE_INDO = 11;
    // malay odds
    const TYPE_MY = 1;

    // returns odd type id in sportsbook
    public static function get_cf_odds($odd_type)
    {
        // hard coded cf88 odds type, please refer to cf888.odds_types table

        if ($odd_type == self::TYPE_DEC)
            return 1;
        else if ($odd_type == self::TYPE_HK)
            return 2;
        else if ($odd_type == self::TYPE_INDO)
            return 3;
        else if ($odd_type == self::TYPE_MY)
            return 4;
    }
}