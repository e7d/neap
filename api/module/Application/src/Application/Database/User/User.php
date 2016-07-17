<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\User;

use Zend\Hydrator\ObjectProperty;

/**
 * User
 */
class User extends ObjectProperty
{
    /** @var string */
    public $user_id;

    /** @var string */
    public $channel_id;

    /** @var string */
    public $username;

    /** @var string */
    public $email;

    /** @var string */
    public $display_name;

    /** @var string */
    public $logo;

    /** @var string */
    public $bio;

    /** @var string */
    public $created_at;

    /** @var string */
    public $updated_at;

    /**
     * @param array $data
     *
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $this->user_id = $data['user_id'];
        $this->channel_id = $data['channel_id'];
        $this->username = $data['username'];
        $this->email = $data['email'];
        $this->display_name = $data['display_name'];
        $this->logo = $data['logo'];
        $this->bio = $data['bio'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }
}
