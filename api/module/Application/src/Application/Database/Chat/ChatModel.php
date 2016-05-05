<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Database\Chat;

use Application\Database\AbstractModel;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\TableGateway\TableGateway;

class ChatModel extends AbstractModel
{
    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetch($chatId)
    {
        $resultSet = $this->tableGateway->select(array('chat_id' => $chatId));
        $chat = $resultSet->current();
        if (!$chat) {
            return null;
        }

        return $chat;
    }

    public function selectByChannel($channelId)
    {
        $where = new Where();
        $where->equalTo('chat.channel_id', $channelId);

        $select = $this->tableGateway->getSql()->select();
        $select->where($where);

        return $select;
    }

    public function fetchByChannel($channelId)
    {
        return $this->selectOne(
            $this->selectByChannel($channelId)
        );
    }

    public function selectModsByUser($userId)
    {
        $where = new Where();
        $where->equalTo('mod.user_id', $userId);

        $select = $this->tableGateway->getSql()->select();
        $select->join('mod', 'mod.chat_id = chat.chat_id', array(), 'inner');
        $select->where($where);

        return $select;
    }
}
