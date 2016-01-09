<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Follow;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Follow extends ObjectProperty
{
    public $user_id;
    public $channel_id;
    public $created_at;

    public function exchangeArray($data)
    {
        $this->user_id = $data['user_id'];
        $this->channel_id = $data['channel_id'];
        $this->created_at = $data['created_at'];
    }
}
