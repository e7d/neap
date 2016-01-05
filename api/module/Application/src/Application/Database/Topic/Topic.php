<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Topic;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Topic extends ObjectProperty
{
    public $id;
    public $name;
    public $created_at;

    public function exchangeArray($data)
    {
        $this->id = $data['topic_id'];
        $this->name = $data['name'];
        $this->created_at = $data['created_at'];

        // Additional data
        if (!empty($data['streams'])) {
            $this->streams = $data['streams'];
        }
        if (!empty($data['viewers'])) {
            $this->viewers = $data['viewers'];
        }
    }
}
