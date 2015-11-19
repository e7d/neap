<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Mod;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Mod extends ObjectProperty
{
    public $user_id;
    public $chat_id;
    public $level;
    public $created_at;
    public $update_at;

    public function exchangeArray($data)
    {
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->chat_id = (!empty($data['chat_id'])) ? $data['chat_id'] : null;
        $this->level = (!empty($data['level'])) ? $data['level'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
        $this->update_at = (!empty($data['update_at'])) ? $data['update_at'] : null;
    }
}
