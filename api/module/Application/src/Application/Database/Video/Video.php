<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
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
        $this->id = (!empty($data['video_id'])) ? $data['video_id'] : null;
        $this->stream_id = (!empty($data['stream_id'])) ? $data['stream_id'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->type = (!empty($data['type'])) ? $data['type'] : null;
        $this->description = (!empty($data['description'])) ? $data['description'] : null;
        $this->status = (!empty($data['status'])) ? $data['status'] : null;
        $this->tags = (!empty($data['tags'])) ? json_decode($data['tags']) : null;
        $this->topic_id = (!empty($data['topic_id'])) ? $data['topic_id'] : null;
        $this->topic = (!empty($data['topic'])) ? $data['topic'] : null;
        $this->media_info = (!empty($data['media_info'])) ? json_decode($data['media_info']) : null;
        $this->preview = (!empty($data['preview'])) ? $data['preview'] : null;
        $this->views = (!empty($data['views'])) ? $data['views'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at'] : null;
    }
}
