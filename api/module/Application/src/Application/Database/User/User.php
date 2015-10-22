<?php
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
        $this->id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->channel_id = (!empty($data['channel_id'])) ? $data['channel_id'] : null;
        $this->username = (!empty($data['username'])) ? $data['username'] : null;
        $this->email = (!empty($data['email'])) ? $data['email'] : null;
        $this->display_name = (!empty($data['display_name'])) ? $data['display_name'] : null;
        $this->logo = (!empty($data['logo'])) ? $data['logo'] : null;
        $this->bio = (!empty($data['bio'])) ? $data['bio'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at'] : null;
    }
}
