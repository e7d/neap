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

namespace Application\Database\Outage;

use Zend\Hydrator\ObjectProperty;

/**
 * Outage
 */
class Outage extends ObjectProperty
{
    /** @var string */
    public $outage_id;

    /** @var string */
    public $ingest_id;

    /** @var string */
    public $started_at;

    /** @var string */
    public $ended_at;

    /**
     * @param array $data
     *
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $this->outage_id = $data['outage_id'];
        $this->ingest_id = $data['ingest_id'];
        $this->started_at = $data['started_at'];
        $this->ended_at = $data['ended_at'];
    }
}
