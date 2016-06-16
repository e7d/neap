<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Channel;

use Zend\Hydrator\ObjectProperty;

class Channel extends ObjectProperty
{
    public $channel_id;
    public $user_id;
    public $chat_id;
    public $name;
    public $stream_key;
    public $title;
    public $topic_id;
    public $topic;
    public $language;
    public $delay;
    public $logo;
    public $banner;
    public $video_banner;
    public $background;
    public $profile_banner;
    public $views;
    public $followers;
    public $created_at;
    public $updated_at;

    public function exchangeArray($data)
    {
        $this->channel_id = $data['channel_id'];
        $this->user_id = $data['user_id'];
        $this->chat_id = $data['chat_id'];
        $this->name = $data['name'];
        $this->stream_key = $data['stream_key'];
        $this->title = $data['title'];
        $this->topic_id = $data['topic_id'];
        $this->topic = $data['topic'];
        $this->language = $data['language'];
        $this->delay = $data['delay'];
        $this->logo = $data['logo'];
        $this->banner = $data['banner'];
        $this->video_banner = $data['video_banner'];
        $this->background = $data['background'];
        $this->profile_banner = $data['profile_banner'];
        $this->views = $data['views'];
        $this->followers = $data['followers'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }
}
