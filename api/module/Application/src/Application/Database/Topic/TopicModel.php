<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Topic;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class TopicModel
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getTableGateway()
    {
        return $this->tableGateway;
    }

    public function fetch($topicId)
    {
        $where = new Where();
        $where->equalTo('topic.topic_id', $topicId);

        $select = new Select('topic');
        $select->columns(array(
            '*',
            'streams' => new Expression('COUNT(stream.stream_id)'),
            'viewers' => new Expression('SUM(stream.viewers)'),
        ));
        $select->join('stream', 'stream.topic_id = topic.topic_id', array(), 'inner');
        $select->where($where);
        $select->group('topic.topic_id');

        $rowset = $this->tableGateway->selectWith($select);
        $topic = $rowset->current();
        if (!$topic) {
            return null;
        }

        return $topic;
    }
}
