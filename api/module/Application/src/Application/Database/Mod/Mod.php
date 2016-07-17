<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Mod;

use Zend\Hydrator\ObjectProperty;

/**
 * Mod
 */
class Mod extends ObjectProperty
{
    /** @var string */
    public $user_id;

    /** @var string */
    public $chat_id;

    /** @var string */
    public $level;

    /** @var string */
    public $created_at;

    /** @var string */
    public $update_at;

    /**
     * @param array $data
     *
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $this->user_id = $data['user_id'];
        $this->chat_id = $data['chat_id'];
        $this->level = $data['level'];
        $this->created_at = $data['created_at'];
        $this->update_at = $data['update_at'];
    }
}
