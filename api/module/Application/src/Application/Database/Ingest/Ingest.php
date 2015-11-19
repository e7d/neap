<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Ingest;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Ingest extends ObjectProperty
{
    public $id;
    public $name;
    public $hostname;
    public $port;
    public $availability;
    public $created_at;
    public $updated_at;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['ingest_id'])) ? $data['ingest_id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->hostname = (!empty($data['hostname'])) ? $data['hostname'] : null;
        $this->port = (!empty($data['port'])) ? $data['port'] : null;
        $this->availability = (!empty($data['availability'])) ? $data['availability'] : null;
        $this->url_template = 'rtmp://'.$this->hostname.($this->port != 1935 ? ':'.$this->port : '').'/live/{stream_key}';
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at'] : null;
    }
}
