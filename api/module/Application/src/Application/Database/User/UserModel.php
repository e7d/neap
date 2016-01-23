<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\User;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class UserModel
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

    public function fetch($userId)
    {
        $rowset = $this->tableGateway->select(array('user_id' => $userId));
        $user = $rowset->current();
        if (!$user) {
            return null;
        }

        return $user;
    }

    public function fetchByChannel($channelId)
    {
        $where = new Where();
        $where->equalTo('channel.channel_id', $channelId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('channel', 'channel.channel_id = user.channel_id', array(), 'inner');
        $select->where($where);

        $rowset = $this->tableGateway->selectWith($select);
        $user = $rowset->current();
        if (!$user) {
            return null;
        }

        return $user;
    }

    public function update($id, $data)
    {
        // todo
        return;
    }
}
