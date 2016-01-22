<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Topic;

use Application\Hydrator\Hydrator;
use ZF\Hal\Entity;

class TopicHydrator extends Hydrator
{
    public function __construct()
    {
        parent::__construct();
    }

    public function buildEntity($topic)
    {
        $topicEntity = new Entity($this->extract($topic), $topic->id);

        $topicEntity->getLinks()->add($this->link::factory(array(
            'rel' => 'self',
            'route' => array(
                'name' => 'topic.rest.topic',
                'params' => array(
                    'topic_id' => $topic->id,
                ),
            ),
        )));

        return $topicEntity;
    }
}
