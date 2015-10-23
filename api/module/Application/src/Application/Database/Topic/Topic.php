<?php
namespace Application\Database\Topic;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Topic extends ObjectProperty
{
    public $id;
    public $name;
    public $created_at;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['topic_id'])) ? $data['topic_id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
    }
}
