<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Chat;

use Zend\Hydrator\ObjectProperty;

class Chat extends ObjectProperty
{
    public $chat_id;
    public $channel_id;
    public $name;
    public $created_at;

    public function exchangeArray($data)
    {
        $this->chat_id = $data['chat_id'];
        $this->channel_id = $data['channel_id'];
        $this->name = $data['name'];
        $this->created_at = $data['created_at'];
    }
}
