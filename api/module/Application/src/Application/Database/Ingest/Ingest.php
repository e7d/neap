<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Ingest;

use Zend\Hydrator\ObjectProperty;

class Ingest extends ObjectProperty
{
    public $ingest_id;
    public $name;
    public $hostname;
    public $port;
    public $availability;
    public $url_template;
    public $created_at;
    public $updated_at;

    public function exchangeArray($data)
    {
        $this->ingest_id = $data['ingest_id'];
        $this->name = $data['name'];
        $this->hostname = $data['hostname'];
        $this->port = $data['port'];
        $this->availability = $data['availability'];
        $this->url_template = 'rtmp://'.$this->hostname.($this->port != 1935 ? ':'.$this->port : '').'/live/{stream_key}';
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }
}
