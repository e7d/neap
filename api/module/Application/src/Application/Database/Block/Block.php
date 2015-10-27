<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Block;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Block extends ObjectProperty
{
    public $user_id;
    public $blocked_user_id;
    public $created_at;

    public function exchangeArray($data)
    {
        $this->user_id = (!empty($data['$user_id'])) ? $data['user_id'] : null;
        $this->blocked_user_id = (!empty($data['blocked_user_id'])) ? $data['blocked_user_id'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
    }
}
