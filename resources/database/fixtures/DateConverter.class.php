<?php
namespace Fixtures;

class DateConverter
{
    public static function fromTimestamp($timestamp = null)
    {
        if ($timestamp === null) {
            $timestamp = microtime(true);
        }

        $date = new \DateTime();
        $timestamp = number_format($timestamp, 4, '.', '');
        $date = $date::createFromFormat('U.u', $timestamp);
        return $date->format('Y-m-d H:i:s.uO');
    }

    /**
     * @param double $max
     */
    public static function randomTimestamp($min = 0, $max = null)
    {
        if ($max === null) {
            $max = microtime(true);
        }

        return self::bigRand($min * 10000, $max * 10000) / 10000;
    }

    /**
     * @param integer $min
     * @param double $max
     */
    private static function bigRand($min, $max)
    {
        $difference   = bcadd(bcsub($max, $min), 1);
        $randPercent = bcdiv(mt_rand(), mt_getrandmax(), 8); // 0 - 1.0
        return bcadd($min, bcmul($difference, $randPercent, 8), 0);
    }
}
