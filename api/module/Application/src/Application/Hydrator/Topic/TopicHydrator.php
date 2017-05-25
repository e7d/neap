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

namespace Application\Hydrator\Topic;

use Application\Database\Topic\Topic;
use Application\Hydrator\Hydrator;
use ZF\Hal\Entity;

/**
 * TopicHydrator
 */
class TopicHydrator extends Hydrator
{
    /**
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Topic $topic
     *
     * @return Entity
     */
    public function buildEntity($topic)
    {
        $this->object = $topic;

        $this->entity = new Entity($this->extract($topic), $topic->topic_id);

        $this->addSelfLink();

        return $this->entity;
    }
}
