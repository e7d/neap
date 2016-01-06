<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Video;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Video extends ObjectProperty
{
    public $id;
    public $stream_id;
    public $title;
    public $type;
    public $description;
    public $status;
    public $tags;
    public $topic_id;
    public $topic;
    public $media_info;
    public $preview;
    public $views;
    public $created_at;
    public $updated_at;

    public function exchangeArray($data)
    {
        $this->id = $data['video_id'];
        $this->stream_id = $data['stream_id'];
        $this->title = $data['title'];
        $this->type = $data['type'];
        $this->description = $data['description'];
        $this->status = $data['status'];
        $this->tags = json_decode($data['tags']);
        $this->topic_id = $data['topic_id'];
        $this->topic = $data['topic'];
        $this->media_info = json_decode($data['media_info']);
        $this->preview = $data['preview'];
        $this->views = $data['views'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }
}
