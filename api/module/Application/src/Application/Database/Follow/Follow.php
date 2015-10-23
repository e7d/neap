<?php
namespace Application\Database\Follow;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Follow extends ObjectProperty
{
    public $user_id;
    public $channel_id;
    public $created_at;

    public function exchangeArray($data)
    {
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->channel_id = (!empty($data['channel_id'])) ? $data['channel_id'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
    }
}
