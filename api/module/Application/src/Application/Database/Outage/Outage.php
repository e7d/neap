<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Outage;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Outage extends ObjectProperty
{
    public $id;
    public $ingest_id;
    public $started_at;
    public $ended_at;

    public function exchangeArray($data)
    {
        $this->id = $data['outage_id'];
        $this->ingest_id = $data['ingest_id'];
        $this->started_at = $data['started_at'];
        $this->ended_at = $data['ended_at'];
    }
}
