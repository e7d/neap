<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
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
        $this->id = (!empty($data['outage_id'])) ? $data['outage_id'] : null;
        $this->ingest_id = (!empty($data['ingest_id'])) ? $data['ingest_id'] : null;
        $this->started_at = (!empty($data['started_at'])) ? $data['started_at'] : null;
        $this->ended_at = (!empty($data['ended_at'])) ? $data['ended_at'] : null;l;
    }
}
