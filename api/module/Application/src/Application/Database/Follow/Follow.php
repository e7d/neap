<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Follow;

use Zend\Hydrator\ObjectProperty;

/**
 * Follow
 */
class Follow extends ObjectProperty
{
    /** @var string */
    public $user_id;

    /** @var string */
    public $channel_id;

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
        $this->channel_id = $data['channel_id'];
        $this->created_at = $data['created_at'];
    }
}
