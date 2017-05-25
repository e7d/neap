<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
 */

namespace Application\Converter;

/**
 * DateConverter converts a timestamp to a formatted date string
 */
class DateConverter
{
    /**
     * Convert a timestamp to a date string
     *
     * @param float $timestamp
     *
     * @return string
     */
    public static function fromTimestamp(float $timestamp = null)
    {
        if ($timestamp === null) {
            $timestamp = microtime(true);
        }

        $timestamp = number_format($timestamp, 6, '.', '');
        $date = \DateTime::createFromFormat('U.u', $timestamp);
        return $date->format('Y-m-d H:i:s.uO');
    }
}
