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

namespace Application\Database\Video;

use Zend\Hydrator\ObjectProperty;

/**
 * Video
 */
class Video extends ObjectProperty
{
    /** @var string */
    public $video_id;

    /** @var string */
    public $stream_id;

    /** @var string */
    public $title;

    /** @var string */
    public $type;

    /** @var string */
    public $description;

    /** @var string */
    public $status;

    /** @var string */
    public $tags;

    /** @var string */
    public $topic_id;

    /** @var string */
    public $topic;

    /** @var string */
    public $media_info;

    /** @var string */
    public $preview;

    /** @var string */
    public $views;

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
        $this->video_id = $data['video_id'];
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
