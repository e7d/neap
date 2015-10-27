<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\User;

use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class UserModel
{
    public $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetch($id)
    {
        $rowset = $this->tableGateway->select(array('user_id' => $id));
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

        $sqlSelect = $this->tableGateway->getSql()->select()->where($where);
        $sqlSelect->join('channel', 'channel.channel_id = user.channel_id', array(), 'left');

        $rowset = $this->tableGateway->selectWith($sqlSelect);
        $user = $rowset->current();
        if (!$user) {
            return null;
        }

        return $user;
    }
}
