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

namespace Application\Database\Topic;

use Zend\Hydrator\ObjectProperty;

/**
 * Topic
 */
class Topic extends ObjectProperty
{
    /** @var string */
    public $topic_id;

    /** @var string */
    public $name;

    /** @var string */
    public $created_at;

    /** @var int */
    public $streams;

    /** @var int */
    public $viewers;

    /**
     * @param array $data
     *
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $this->topic_id = $data['topic_id'];
        $this->name = $data['name'];
        $this->created_at = $data['created_at'];

        // Additional data
        if (!empty($data['streams'])) {
            $this->streams = $data['streams'];
        }
        if (!empty($data['viewers'])) {
            $this->viewers = $data['viewers'];
        }
    }
}
