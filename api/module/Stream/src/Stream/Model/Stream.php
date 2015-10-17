<?php
namespace Stream\Model;

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
        $this->id = (!empty($data['stream_id'])) ? $data['stream_id'] : null;
        $this->channel_id = (!empty($data['channel_id'])) ? $data['channel_id'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->topic_id = (!empty($data['topic_id'])) ? $data['topic_id'] : null;
        $this->topic = (!empty($data['topic'])) ? $data['topic'] : null;
        $this->media_info = (!empty($data['media_info'])) ? $data['media_info'] : null;
        $this->viewers = (!empty($data['viewers'])) ? $data['viewers'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at'] : null;
        $this->ended_at = (!empty($data['ended_at'])) ? $data['ended_at'] : null;
    }
}
