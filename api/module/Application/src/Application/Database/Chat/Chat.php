<?php
namespace Application\Database\Chat;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Chat extends ObjectProperty
{
    public $id;
    public $channel_id;
    public $name;
    public $created_at;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['chat_id'])) ? $data['chat_id'] : null;
        $this->channel_id = (!empty($data['channel_id'])) ? $data['channel_id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
    }
}
