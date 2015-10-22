<?php
namespace Application\Database\Block;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Block extends ObjectProperty
{
    public $id;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['block_id'])) ? $data['block_id'] : null;
    }
}
