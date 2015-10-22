<?php
namespace Application\Database\Panel;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Panel extends ObjectProperty
{
    public $id;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['panel_id'])) ? $data['panel_id'] : null;
    }
}
