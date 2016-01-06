<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\User;

use Zend\Stdlib\Hydrator\ObjectProperty;

class User extends ObjectProperty
{
    public $id;
    public $username;
    public $email;
    public $display_name;
    public $logo;
    public $bio;
    public $created_at;
    public $updated_at;

    public function exchangeArray($data)
    {
        $this->id = $data['user_id'];
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
