<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Stream;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Stream extends ObjectProperty
{
    public $id;
    public $channel_id;
    public $title;
    public $topic_id;
    public $topic;
    public $media_info;
    public $viewers;
    public $created_at;
    public $updated_at;
    public $ended_at;

    public function exchangeArray($data)
    {
        $this->id = $data['stream_id'];
        $this->channel_id = $data['channel_id'];
        $this->title = $data['title'];
        $this->topic_id = $data['topic_id'];
        $this->topic = $data['topic'];
        $this->media_info = json_decode($data['media_info']);
        $this->viewers = $data['viewers'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->ended_at = $data['ended_at'];
    }
}
