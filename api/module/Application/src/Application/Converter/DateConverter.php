<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Converter;

class DateConverter
{
    public static function fromTimestamp($timestamp = null)
    {
        if ($timestamp === null) {
            $timestamp = microtime(true);
        }

        $timestamp = number_format($timestamp, 6, '.', '');
        $date = \DateTime::createFromFormat('U.u', $timestamp);
        return $date->format('Y-m-d H:i:s.uO');
    }
}
