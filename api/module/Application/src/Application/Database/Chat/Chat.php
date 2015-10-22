<?php
namespace Application\Database\Chat;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Chat extends ObjectProperty
{
    public $id;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['chat_id'])) ? $data['chat_id'] : null;
    }
}
