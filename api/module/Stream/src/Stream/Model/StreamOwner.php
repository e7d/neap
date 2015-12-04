<?php
namespace Stream\Model;

class StreamOwner
{
    public $user_id;
    public $channel_id;
    public $stream_id;

    public function exchangeArray($data)
    {
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->channel_id = (!empty($data['channel_id'])) ? $data['channel_id'] : null;
        $this->stream_id = (!empty($data['stream_id'])) ? $data['stream_id'] : null;
    }
}
