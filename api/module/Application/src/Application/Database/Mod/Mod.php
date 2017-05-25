<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
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
