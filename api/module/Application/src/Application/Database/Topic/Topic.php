<?php
namespace Application\Database\Topic;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Topic extends ObjectProperty
{
    public $id;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['topic_id'])) ? $data['topic_id'] : null;
    }
}
