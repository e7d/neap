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
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

/**
 * Topic Model
 */
class TopicModel extends AbstractModel
{
    /**
     * @param TableGateway $tableGateway
     */
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    /**
     * @param string $topicId
     *
     * @return Select
     */
    public function select(string $topicId)
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

    /**
     * @param string $topicId
     *
     * @return Topic|null
     */
    public function fetch(string $topicId)
    {
        return $this->selectOne(
            $this->select($topicId)
        );
    }

    /**
     * @return Select
     */
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


    /**
     * @return ResultSet
     */
    public function fetchWithStats()
    {
        return $this->selectAll(
            $this->selectWithStats()
        );
    }
}
