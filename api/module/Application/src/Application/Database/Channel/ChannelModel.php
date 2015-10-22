<?php
namespace Application\Database\Channel;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class ChannelModel
{
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetch($id)
    {
        $rowset = $this->tableGateway->select(array('channel_id' => $id));
        $channel = $rowset->current();
        if (!$channel) {
            return null;
        }

        return $channel;
    }

    public function fetchByUser($userId)
    {
        $where = new Where();
        $where->equalTo('user.user_id', $userId);

        $sqlSelect = $this->tableGateway->getSql()->select()->where($where);
        $sqlSelect->join('user', 'user.user_id = channel.user_id', array(), 'left');

        $rowset = $this->tableGateway->selectWith($sqlSelect);
        $channel = $rowset->current();
        if (!$channel) {
            return null;
        }

        return $channel;
    }
}
