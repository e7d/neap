<?php
namespace Application\Database\Block;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Block extends ObjectProperty
{
    public $user_id;
    public $blocked_user_id;
    public $created_at;

    public function exchangeArray($data)
    {
        $this->user_id = (!empty($data['$user_id'])) ? $data['user_id'] : null;
        $this->blocked_user_id = (!empty($data['blocked_user_id'])) ? $data['blocked_user_id'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
    }
}
