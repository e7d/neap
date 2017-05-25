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

namespace Application\Database\Block;

use Zend\Hydrator\ObjectProperty;

/**
 * Block
 */
class Block extends ObjectProperty
{
    /** @var string */
    public $user_id;

    /** @var string */
    public $blocked_user_id;

    /** @var string */
    public $created_at;

    /**
     * @param array $data
     *
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $this->user_id = $data['user_id'];
        $this->blocked_user_id = $data['blocked_user_id'];
        $this->created_at = $data['created_at'];
    }
}
