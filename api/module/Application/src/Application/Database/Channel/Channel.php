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

/**
 * Channel
 */
class Channel extends ObjectProperty
{
    /** @var string */
    public $channel_id;

    /** @var string */
    public $user_id;

    /** @var string */
    public $chat_id;

    /** @var string */
    public $name;

    /** @var string */
    public $stream_key;

    /** @var string */
    public $title;

    /** @var string */
    public $topic_id;

    /** @var string */
    public $topic;

    /** @var string */
    public $language;

    /** @var string */
    public $delay;

    /** @var string */
    public $logo;

    /** @var string */
    public $banner;

    /** @var string */
    public $video_banner;

    /** @var string */
    public $background;

    /** @var string */
    public $profile_banner;

    /** @var string */
    public $views;

    /** @var string */
    public $followers;

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
