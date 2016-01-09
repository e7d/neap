<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Topic\V1\Service;

use Application\Database\Topic\Topic;
use Topic\V1\Rest\Topic\TopicCollection;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class TopicService
{
    protected $topicModel;
    protected $topicHydrator;

    public function __construct($topicModel, $topicHydrator)
    {
        $this->topicModel = $topicModel;
        $this->topicHydrator = $topicHydrator;
    }

    public function fetchAll($params = [])
    {
        $select = new Select('topic');
        $select->columns(array(
            '*',
            'streams' => new Expression('COUNT(stream.stream_id)'),
            'viewers' => new Expression('SUM(stream.viewers)'),
        ));
        $select->join('stream', 'stream.topic_id = topic.topic_id', array(), 'inner');
        $select->group('topic.topic_id');
        if (array_key_exists('top', $params)) {
            $select->order('viewers DESC');
        }

        $hydratingResultSet = new HydratingResultSet(
            $this->topicHydrator,
            new Topic()
        );

        $paginatorAdapter = new DbSelect(
            $select,
            $this->topicModel->getTableGateway()->getAdapter(),
            $hydratingResultSet
        );

        $collection = new TopicCollection($paginatorAdapter);
        return $collection;
    }

    public function fetch($id)
    {
        $topic = $this->topicModel->fetch($id);
        if (!$topic) {
            return null;
        }

        return $this->topicHydrator->buildEntity($topic);
    }
}
