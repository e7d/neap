<?php
namespace Application\Database\Mod;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Mod extends ObjectProperty
{
    public $id;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['mod_id'])) ? $data['mod_id'] : null;
    }
}
