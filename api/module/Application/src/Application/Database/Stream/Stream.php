<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Stream;

use Zend\Hydrator\ObjectProperty;

/**
 * Stream
 */
class Stream extends ObjectProperty
{
    /** @var string */
    public $stream_id;

    /** @var string */
    public $channel_id;

    /** @var string */
    public $title;

    /** @var string */
    public $topic_id;

    /** @var string */
    public $topic;

    /** @var string */
    public $media_info;

    /** @var string */
    public $viewers;

    /** @var string */
    public $created_at;

    /** @var string */
    public $updated_at;

    /** @var string */
    public $ended_at;

    /**
     * @param array $data
     *
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $this->stream_id = $data['stream_id'];
        $this->channel_id = $data['channel_id'];
        $this->title = $data['title'];
        $this->topic_id = $data['topic_id'];
        $this->topic = $data['topic'];
        $this->media_info = json_decode($data['media_info']);
        $this->viewers = $data['viewers'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
        $this->ended_at = $data['ended_at'];
    }
}
