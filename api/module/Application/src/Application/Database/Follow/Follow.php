<?php
namespace Application\Database\Follow;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Follow extends ObjectProperty
{
    public $id;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['follow_id'])) ? $data['follow_id'] : null;
    }
}
