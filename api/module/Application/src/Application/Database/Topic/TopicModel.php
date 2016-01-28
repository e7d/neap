<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Topic;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class TopicModel extends AbstractModel
{
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function select($topicId)
    {
        $where = new Where();
        $where->equalTo('topic.topic_id', $topicId);

        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            '*',
            'streams' => new Expression('COUNT(stream.stream_id)'),
            'viewers' => new Expression('SUM(stream.viewers)'),
        ));
        $select->join('stream', 'stream.topic_id = topic.topic_id', array(), 'inner');
        $select->where($where);
        $select->group('topic.topic_id');

        return $select;
    }

    public function fetch($topicId)
    {
        return $this->selectOne(
            $this->select($topicId)
        );
    }

    public function selectWithStats()
    {
        $select = $this->tableGateway->getSql()->select();
        $select->columns(array(
            '*',
            'streams' => new Expression('COUNT(stream.stream_id)'),
            'viewers' => new Expression('SUM(stream.viewers)'),
        ));
        $select->join('stream', 'stream.topic_id = topic.topic_id', array(), 'inner');
        $select->group('topic.topic_id');

        return $select;
    }

    public function fetchWithStats()
    {
        return $this->selectAll(
            $this->selectWithStats()
        );
    }
}
